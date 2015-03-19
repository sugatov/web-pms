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

    public function getCurrentUser()
    {
        $IPaddr = $_SERVER['REMOTE_ADDR'];
        // If you serving through a reverse proxy without mod_realip
        /*if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $IPaddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }*/
        return $this->find($IPaddr);
    }
}
