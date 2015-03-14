<?php
interface StorageInterface
{
    /**
     * @param  string $name
     * @return string|null
     */
    public function read($name);

    /**
     * @param string $name
     * @param string $data
     */
    public function write($name, $data);

    /**
     * @param  string $name
     * @return boolean
     */
    public function exists($name);

    /**
     * @param  string $name
     */
    public function delete($name);
}
