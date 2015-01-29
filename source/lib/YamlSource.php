<?php
use Symfony\Component\Yaml\Yaml;

class YamlSource implements \ArrayAccess
{
    protected $_container;
    protected $_paths;
    protected $_paths_search;
    protected $_paths_replace;

    public function __construct($filename, $paths = null)
    {
        $cwd = getcwd();
        $this->_paths = $paths;
        $this->_paths_search = array();
        $this->_paths_replace = array();
        if (is_array($this->_paths)) {
            foreach($this->_paths as $search=>$replace) {
                $this->_paths_search[]  = $search;
                $this->_paths_replace[] = $replace;
            }
        }
        $filename = realpath($filename);
        $this->_container = $this->_parseYaml($filename);
        chdir($cwd);
    }

    protected function _parseYaml($filename)
    {
        if ( ! is_file($filename)) {
            throw new \RuntimeException('Could not find a file: "' . $filename . '"');
        }
        $data = Yaml::parse(file_get_contents($filename));
        if (is_array($this->_paths)) {
            $this->_fixPaths($data);
        }
        chdir(dirname($filename));
        $this->_imports($data, $filename);
        return $data;
    }

    protected function _imports(&$node, $filename)
    {
        $filename = realpath($filename);
        if (isset($node['!imports']) && is_array($node['!imports'])) {
            foreach($node['!imports'] as &$import) {
                chdir(dirname($filename));
                $importFilename = realpath($import);
                $childNode = $this->_parseYaml($importFilename);
                $node = array_replace_recursive($childNode, $node);
                unset($import);
            }
            unset($node['!imports']);
        }
        if (is_array($node)) {
            foreach($node as &$element) {
                if (is_array($element)) {
                    $this->_imports($element, $filename);
                }
                unset($element);
            }
        }
    }

protected function _fixPaths(&$array)
    {
        $pathSearch = $this->_paths_search;
        $pathReplace = $this->_paths_replace;
        array_walk_recursive($array, function(&$element, $key) use ($pathSearch, $pathReplace) {
            $element = str_replace($pathSearch, $pathReplace, $element);
        });
    }

    public function offsetGet($key)
    {
        return $this->_container[$key];
    }

    public function offsetSet($key, $value)
    {
        $this->_container[$key] = $value;
    }

    public function offsetExists($key)
    {
        return isset($this->_container[$key]);
    }

    public function offsetUnset($key)
    {
        unset($this->_container[$key]);
    }
}
