<?php
namespace App\Model\Repositories;

use Doctrine\ORM\EntityRepository;
use App\Model\Entities\User;

class Users extends EntityRepository
{
    /**
     * Find a user by primary key or create him if he does not exist
     * @param  string $id
     * @return User
     */
    public function find($id)
    {
        return $this->findOneById($id);
    }

    /**
     * Find a user by primary key or create him if he does not exist
     * @param  string $id
     * @return User
     */
    public function findOneById($id)
    {
        $entity = parent::findOneById($id);
        if ( ! $entity) {
            $entity = new User();
            $entity->setId($id);
            $this->getEntityManager()->persist($entity);
        }
        return $entity;
    }
}
