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

    protected function checkFile($filename, $maxAge = 0)
    {
        if ( ! file_exists($filename)) {
            return false;
        }
        if (is_int($maxAge) && $maxAge > 0 && (time() - filemtime($filename)) > $maxAge) {
            return false;
        }
        return true;
    }

    /**
     * @param  string  $key
     * @param  integer $maxAge
     * @return string|null
     */
    public function get($key, $maxAge = 0)
    {
        $filename = $this->getFilename($key);
        if ($this->checkFile($filename, $maxAge)) {
            return file_get_contents($filename);
        }
        return null;
    }

    /**
     * @param string $key
     * @param string $data
     */
    public function set($key, $data)
    {
        $filename = $this->getFilename($key);
        file_put_contents($filename, $data);
    }

    /**
     * @param  string  $key
     * @param  integer $maxAge
     * @return boolean
     */
    public function exists($key, $maxAge = 0)
    {
        $filename = $this->getFilename($key);
        return $this->checkFile($filename, $maxAge);
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
                throw new \RuntimeException('Could not delete this file!');
            }
        }
    }
}
