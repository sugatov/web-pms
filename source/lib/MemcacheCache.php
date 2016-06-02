<?php
class MemcacheCache implements CacheInterface
{
    /**
     * @var \Memcache
     */
    protected $connection;

    /**
     * @param string $host
     * @throws \RuntimeException
     */
    public function __construct($host)
    {
        $this->connection = memcache_connect($host);
    }

    protected function check($key)
    {
        if ($this->connection->get($key) === false) {
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
        if ($this->check($key)) {
            return $this->connection->get($key);
        }
        return null;
    }

    /**
     * @param string  $key
     * @param integer $maxAge
     * @param string  $data
     */
    public function set($key, $data, $maxAge = 0)
    {
        if (is_integer($maxAge) && $maxAge > 0) {
            $maxAge = time() + $maxAge;
            $this->connection->set($key, $data, 0, $maxAge);
        } else {
            $this->connection->set($key, $data);
        }
    }

    /**
     * @param  string  $key
     * @return boolean
     */
    public function exists($key)
    {
        return $this->check($key);
    }

    /**
     * @param  string $key
     * @throws \RuntimeException
     */
    public function delete($key)
    {
        if ($this->connection->delete($key) === false) {
            throw new \RuntimeException('Cache item deleting error!');
        }
    }
}
