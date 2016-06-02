<?php
interface CacheInterface
{
    /**
     * @param  string  $key
     * @return string|null
     */
    public function get($key);

    /**
     * @param string $key
     * @param string $data
     * @param integer $maxAge
     */
    public function set($key, $data, $maxAge = 0);

    /**
     * @param  string  $key
     * @return boolean
     */
    public function exists($key);

    /**
     * @param  string $key
     */
    public function delete($key);
}
