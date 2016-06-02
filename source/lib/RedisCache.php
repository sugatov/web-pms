<?php
class RedisCache implements CacheInterface
{
    /**
     * @var \Predis\Client
     */
    protected $connection;

    public function __construct()
    {
        $this->connection = new \Predis\Client();
    }

    protected function check($key)
    {
        if ($this->connection->exists($key) == 0) {
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
     * @param string  $data
     * @param integer $maxAge
     */
    public function set($key, $data, $maxAge = 0)
    {
        if (is_integer($maxAge) && $maxAge > 0) {
            $this->connection->setex($key, $maxAge, $data);
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
        if ($this->connection->del($key) != 1) {
            throw new \RuntimeException('Cache item deleting error!');
        }
    }
}
