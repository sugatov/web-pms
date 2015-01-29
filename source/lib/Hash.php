<?php
class Hash
{
    protected $__alg;
    protected $__salt;

    public function __construct($alg, $salt)
    {
        $this->__alg  = $alg;
        $this->__salt = $salt;
    }

    public function hash($string)
    {
        return hash($this->__alg, $string);
    }

    public function saltedHash($string)
    {
        return $this->hash($string . $this->__salt);
    }
}
