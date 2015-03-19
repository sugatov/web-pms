<?php
use Opensoft\SimpleSerializer\Serializer;

interface ControllerServiceProviderInterface
{
    /**
     * @return Serializer
     */
    public function getSerializer();

    /**
     * @return ArrayAccess
     */
    public function getSession();
}
