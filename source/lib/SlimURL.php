<?php
use Slim\Slim;

class SlimURL implements URLInterface
{
    protected $slim;
    
    public function __construct(Slim $slim)
    {
        $this->slim = $slim;
    }

    public function getUrl($name, $argv = array())
    {
        return $this->slim->urlFor($name, $argv);
    }
}
