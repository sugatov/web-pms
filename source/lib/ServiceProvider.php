<?php
abstract class ServiceProvider
{
    /**
     * @var ArrayAccess
     */
    protected $serviceLocator;
    public function __construct(ArrayAccess $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
}
