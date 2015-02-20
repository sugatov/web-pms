<?php
interface CacheInterface
{
    /**
     * @param  string  $key
     * @param  integer $maxAge
     * @return string|null
     */
    public function get($key, $maxAge = 0);

    /**
     * @param string $key
     * @param string $data
     */
    public function set($key, $data);

    /**
     * @param  string  $key
     * @param  integer $maxAge
     * @return boolean
     */
    public function exists($key, $maxAge = 0);

    /**
     * @param  string $key
     */
    public function delete($key);
}
