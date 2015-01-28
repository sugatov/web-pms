<?php
namespace Hotel;

use ServiceLocator;

class Entity
{
    protected function _getService($name)
    {
        return ServiceLocator::getInstance()->offsetGet($name);
    }

    protected function _getEntity($class, $id)
    {
        return $this->getService('entityManager')->find($class, $id);
    }

    protected function _getRepository($class)
    {
        return $this->_getService('entityManager')->getEntityRepository($class);
    }
}
