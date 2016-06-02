<?php
class FileCache implements CacheInterface
{
    /**
     * @var string
     */
    protected $directory;

    /**
     * @param string $directory
     * @throws \RuntimeException
     */
    public function __construct($directory)
    {
        if ( ! is_dir($directory)) {
            throw new \RuntimeException('Given directory actually is not a directory!');
        }
        $this->directory = $directory;
    }

    protected function getFilename($key)
    {
        return $this->directory . DIRECTORY_SEPARATOR . sprintf('%u', crc32($key)) . '.cache';
    }

    protected function checkFile($filename)
    {
        if ( ! file_exists($filename)) {
            return false;
        }
        if (time() > filemtime($filename)) {
            return false;
        }
        return true;
    }

    /**
     * @param  string  $key
     * @return string|null
     */
    public function get($key)
    {
        $filename = $this->getFilename($key);
        if ($this->checkFile($filename)) {
            return file_get_contents($filename);
        }
        return null;
    }

    /**
     * @param string  $key
     * @param string  $data
     * @param integer $maxAge
     */
    public function set($key, $data, $maxAge = 0)
    {
        $until = 2147483647;
        if (is_integer($maxAge) && $maxAge > 0) {
            $until = time() + $maxAge;
        }
        $filename = $this->getFilename($key);
        file_put_contents($filename, $data);
        touch($filename, $until);
    }

    /**
     * @param  string  $key
     * @return boolean
     */
    public function exists($key)
    {
        $filename = $this->getFilename($key);
        return $this->checkFile($filename);
    }

    /**
     * @param  string $key
     * @throws \RuntimeException
     */
    public function delete($key)
    {
        $filename = $this->getFilename($key);
        if (file_exists($filename)) {
            if ( ! unlink($filename)) {
                throw new \RuntimeException('Could not delete this cache file!');
            }
        }
    }
}
