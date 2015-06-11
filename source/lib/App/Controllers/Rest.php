<?php
namespace App\Controllers;

use Slim\Slim;
use Doctrine\Common\Persistence\ObjectManager;
use App\ServiceProviderInterface;
use RestController;

class Rest extends RestController
{
    /**
     * @var array
     */
    protected $readable;

    /**
     * @var array
     */
    protected $writable;

    public function __construct(Slim $application,
                                array $globalViewScope,
                                ServiceProviderInterface $serviceProvider,
                                ObjectManager $objectManager,
                                array $readable,
                                array $writable)
    {
        parent::__construct($application, $globalViewScope, $serviceProvider, $objectManager);

        $this->readable = $readable;
        $this->writable = $writable;
    }

    protected function getClass($class)
    {
        return 'App\\Model\\Entities\\' . $class;
    }

    public function cnt($class)
    {
        if ( ! in_array($class, $this->readable)) {
            $this->addError('Forbidden', 403);
            $this->jsonResponse(null, 403, 'Forbidden');
        } else {
            parent::cnt($class);
        }
    }

    public function lst($class, $limit = null, $offset = null, $orderBy = null, $desc = false)
    {
        if ( ! in_array($class, $this->readable)) {
            $this->addError('Forbidden', 403);
            $this->jsonResponse(null, 403, 'Forbidden');
        } else {
            parent::lst($class, $limit, $offset, $orderBy, $desc);
        }
    }

    public function find($class, $limit = null, $offset = null, $orderBy = null, $desc = false)
    {
        if ( ! in_array($class, $this->readable)) {
            $this->addError('Forbidden', 403);
            $this->jsonResponse(null, 403, 'Forbidden');
        } else {
            parent::find($class, $limit, $offset, $orderBy, $desc);
        }
    }

    public function getNew($class)
    {
        if ( ! in_array($class, $this->readable)) {
            $this->addError('Forbidden', 403);
            $this->jsonResponse(null, 403, 'Forbidden');
        } else {
            parent::getNew($class);
        }
    }

    public function get($class, $id)
    {
        if ( ! in_array($class, $this->readable)) {
            $this->addError('Forbidden', 403);
            $this->jsonResponse(null, 403, 'Forbidden');
        } else {
            parent::get($class, $id);
        }
    }


    public function post($class)
    {
        if ( ! in_array($class, $this->writable)) {
            $this->addError('Forbidden', 403);
            $this->jsonResponse(null, 403, 'Forbidden');
        } else {
            parent::post($class);
        }
    }

    public function put($class, $id)
    {
        if ( ! in_array($class, $this->writable)) {
            $this->addError('Forbidden', 403);
            $this->jsonResponse(null, 403, 'Forbidden');
        } else {
            parent::put($class, $id);
        }
    }

    public function delete($class, $id)
    {
        if ( ! in_array($class, $this->writable)) {
            $this->addError('Forbidden', 403);
            $this->jsonResponse(null, 403, 'Forbidden');
        } else {
            parent::delete($class, $id);
        }
    }

    public function patch($class, $id)
    {
        if ( ! in_array($class, $this->writable)) {
            $this->addError('Forbidden', 403);
            $this->jsonResponse(null, 403, 'Forbidden');
        } else {
            parent::patch($class, $id);
        }
    }

}
