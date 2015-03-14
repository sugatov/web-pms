<?php
class ControllerServiceProvider extends ServiceProvider implements ControllerServiceProviderInterface
{
    public function getSerializer()
    {
        return $this->serviceLocator['serializer'];
    }

    public function getSession()
    {
        return $this->serviceLocator['session'];
    }
}
