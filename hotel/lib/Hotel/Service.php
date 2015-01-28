<?php
namespace Hotel;

use \ServiceLocator;

class Service
{
    protected $entityManager;
    protected $config;

    public function __construct()
    {
        $this->entityManager = $this->getService('entityManager');
        $this->config        = $this->getService('config');
    }

    protected function getService($name)
    {
        return ServiceLocator::getInstance()->offsetGet($name);
    }
}
