<?php
namespace App\Services;

use \RepositoryBasedService;
use \Doctrine\Common\Persistence\ObjectManager;
use \App\Model\Entities\User;

class Users extends RepositoryBasedService
{
    /**
     * @var \App\Model\Repositories\Users
     */
    protected $repository;

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct($objectManager, 'App:User');
    }
}
