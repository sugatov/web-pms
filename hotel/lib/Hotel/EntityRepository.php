<?php
namespace Hotel;

use \Doctrine\ORM\EntityRepository as DEntityRepository;
use \ServiceLocator;

class EntityRepository extends DEntityRepository
{
    protected function _getService($name)
    {
        return ServiceLocator::getInstance()->offsetGet($name);
    }
}
