<?php

namespace DomainBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use DomainBundle\Entity;

class DoctrineListener
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $om = $args->getObjectManager();

        // FIXME: Автоматическая генерация номера договора
        if ($entity instanceof Entity\Contract) {
            if ($entity->getNumber() === '0') {
                $entity->setNumber($entity->getId());
                $om->persist($entity);
                $om->flush();
            }
        }
    }
}
