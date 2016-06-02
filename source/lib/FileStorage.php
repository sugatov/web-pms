<?php
class FileStorage implements StorageInterface
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

    protected function getFilename($name)
    {
        if ( ! preg_match('/^[0-9a-zA-Z.\-_]+$/', $name)) {
            throw new \RuntimeException('A storage name should not contain any special characters in it!');
        }
        return $this->directory . DIRECTORY_SEPARATOR . $name;
    }

    protected function getStockFilename($name)
    {
        if ( ! preg_match('/^[0-9a-zA-Z.\-_]+$/', $name)) {
            throw new \RuntimeException('A storage name should not contain any special characters in it!');
        }
        return $this->directory . DIRECTORY_SEPARATOR . 'stock' . DIRECTORY_SEPARATOR . $name;
    }

    protected function getActualFilename($name)
    {
        $stock = $this->getStockFilename($name);
        $new = $this->getFilename($name);
        if ( ! file_exists($new) && file_exists($stock)) {
            return $stock;
        } else {
            return $new;
        }
    }

    /**
     * @param  string $name
     * @return string|null
     */
    public function read($name)
    {
        if ( ! $this->exists($name)) {
            throw new \RuntimeException('Could not find a storage entry!');
        }
        $filename = $this->getActualFilename($name);
        return file_get_contents($filename);
    }

    /**
     * @param string $name
     * @param string $data
     * @throws \RuntimeException
     */
    public function write($name, $data)
    {
        $filename = $this->getFilename($name);
        if (file_put_contents($filename, $data, LOCK_EX) === false) {
            throw new \RuntimeException('Could not write to storage!');
        }
    }

    /**
     * @param  string $name
     * @param  string $data
     * @throws \RuntimeException
     */
    public function append($name, $data)
    {
        $stock = $this->getStockFilename($name);
        $new = $this->getFilename($name);
        if ( ! file_exists($new) && file_exists($stock)) {
            copy($stock, $new);
        }
        if (file_put_contents($new, $data, FILE_APPEND | LOCK_EX) === false) {
            throw new \RuntimeException('Could not write to storage!');
        }
    }

    /**
     * @param  string $name
     * @return boolean
     */
    public function exists($name)
    {
        $stock = file_exists($this->getStockFilename($name));
        $new = file_exists($this->getFilename($name));
        return $new | $stock;
    }

    /**
     * @param  string $name
     * @throws \RuntimeException
     */
    public function delete($name)
    {
        $filename = $this->getFilename($name);
        if ( ! $this->exists($name)) {
            throw new \RuntimeException('Could not find a storage entry!');
        }
        if ( ! unlink($filename)) {
            throw new \RuntimeException('Could not delete a storage entry!');
        }
    }
}
