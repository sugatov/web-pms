<?php
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @var ArrayAccess
     */
    protected $serviceLocator;
    public function __construct(ArrayAccess $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
    
    public function getSerializer()
    {
        return $this->serviceLocator['serializer'];
    }

    public function getSession()
    {
        return $this->serviceLocator['session'];
    }
}
