<?php
use \Doctrine\Common\Persistence\ObjectManager;
use \Doctrine\Common\Persistence\ObjectRepository;

class RepositoryBasedService extends Service
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;
    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager    $objectManager
     * @param string                                        $entityName
     */
    public function __construct(ObjectManager $objectManager, $entityName)
    {
        parent::__construct();

        $this->objectManager = $objectManager;
        $this->repository    = $this->objectManager->getRepository($entityName);
    }

    public function __call($method, $argv)
    {
        return call_user_func_array(array($this->repository, $method), $argv);
    }
}
