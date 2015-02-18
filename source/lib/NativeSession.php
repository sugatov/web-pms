<?php
class NativeSession implements ArrayAccess
{
    protected $storage;

    public function __construct()
    {
        session_cache_limiter(false);
        session_start();
        $this->storage = $_SESSION;
    }

    public function offsetSet($offset, $value)
    {
        $this->storage[$offset] = $value;
    }

    public function offsetExists($offset)
    {
        return isset($this->storage[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->storage[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->storage[$offset]) ? $this->storage[$offset] : null;
    }
}
