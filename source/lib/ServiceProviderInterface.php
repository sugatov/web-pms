<?php
use Opensoft\SimpleSerializer\Serializer;

interface ServiceProviderInterface
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
