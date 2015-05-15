<?php
use Slim\Slim;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Opensoft\SimpleSerializer\Serializer;

class RestController extends Controller
{
    /**
     * @var Slim
     */
    protected $application;
    /**
     * @var ObjectManager
     */
    protected $objectManager;
    /**
     * @var Serializer
     */
    protected $serializer;

    public function __construct(Slim $application, ObjectManager $objectManager, Serializer $serializer, array $globalViewScope, ServiceProviderInterface $serviceProvider)
    {
        parent::__construct($application, $globalViewScope, $serviceProvider);

        $this->application = $application;
        $this->objectManager = $objectManager;
        $this->serializer = $serializer;
    }

    protected function getClass($class)
    {
        return 'App\\Model\\Entities\\' . $class;
    }

    protected function classExists($class)
    {
        if ( ! class_exists($class)) {
            $errmsg = 'Entity class not found!';
            $this->addError($errmsg);
            $this->jsonResponse(null, 404, $errmsg);
            return false;
        }
        return true;
    }

    protected function findBy($class, array $criteria, $limit = null, $offset = null, $orderBy = null, $desc = false)
    {
        if ($orderBy) {
            $desc = (bool) $desc;
            $order = $desc ? 'DESC' : 'ASC';
            $orderBy = array($orderBy => $order);
        }
        if ($limit && ! is_numeric($limit) || $limit < 0) {
            $limit = null;
        }
        if ($offset && ! is_numeric($offset) || $offset < 0) {
            $offset = null;
        }
        return $this->objectManager->getRepository($class)
                                   ->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function options()
    {
        $this->jsonResponse(null, 501);
    }

    public function cnt($class)
    {
        $class = $this->getClass($class);
        $criteria = null;
        if ($this->request()->isPost()) {
            $criteria = $this->serializer->unserialize($this->getRawInput());
        }
        $cnt = null;
        if ($this->objectManager instanceof EntityManager) {
            /**
             * @var EntityManager
             */
            $em = $this->objectManager;
            $qb = $em->createQueryBuilder()
                     ->select('COUNT(e)')
                     ->from($class, 'e');
            if ($criteria) {
                foreach ($criteria as $property => $value) {
                    $qb->andWhere('e.' . $property . ' = :' . $property)
                       ->setParameter($property, $value);
                }
            }
            $cnt = $qb->getQuery()->getSingleScalarResult();
        } else {
            $rep = $this->objectManager->getRepository($class);
            if ($criteria) {
                $cnt = count($rep->findBy($criteria));
            } else {
                $cnt = count($rep->findAll());
            }
        }
        $this->jsonResponse($cnt, 200);
    }

    public function lst($class, $limit = null, $offset = null, $orderBy = null, $desc = false)
    {
        $class = $this->getClass($class);
        if ($this->classExists($class)) {
            $list = $this->findBy($class, array(), $limit, $offset, $orderBy, $desc);
            $this->jsonResponse($list, 200);
        }
    }

    public function find($class, $limit = null, $offset = null, $orderBy = null, $desc = false)
    {
        $class = $this->getClass($class);
        if ($this->classExists($class)) {
            $criteria = $this->serializer->unserialize($this->getRawInput());
            $list = $this->findBy($class, $criteria, $limit, $offset, $orderBy, $desc);
            $this->jsonResponse($list, 200);
        }
    }

    public function getNew($class)
    {
        $class = $this->getClass($class);
        if ($this->classExists($class)) {
            $entity = new $class();
            $this->jsonResponse($entity, 200);
        }
    }

    public function get($class, $id)
    {
        $class = $this->getClass($class);
        if ($this->classExists($class)) {
            $entity = $this->objectManager->find($class, $id);
            if ( ! $entity) {
                $errmsg = 'Entity not found!';
                $this->addError($errmsg);
                return $this->jsonResponse(null, 204, $errmsg);
            }
            $this->jsonResponse($entity, 200);
        }
    }

    public function post($class)
    {
        $class = $this->getClass($class);
        if ($this->classExists($class)) {
            $entity = new $class;
            $entity = $this->serializer->unserialize($this->getRawInput(), $entity);
            $this->objectManager->persist($entity);
            $this->objectManager->flush();
            $this->jsonResponse($entity, 201);
        }
    }

    // используется только для обновления
    public function put($class, $id)
    {
        $class = $this->getClass($class);
        if ($this->classExists($class)) {
            $entity = $this->objectManager->find($class, $id);
            if ( ! $entity) {
                $errmsg = 'Entity not found!';
                $this->addError($errmsg);
                return $this->jsonResponse(null, 204, $errmsg);
            }
            $entity = $this->serializer->unserialize($this->getRawInput(), $entity);
            $this->objectManager->flush();
            $this->jsonResponse($entity, 200);
        }
    }

    public function delete($class, $id)
    {
        $class = $this->getClass($class);
        if ($this->classExists($class)) {
            $entity = $this->objectManager->find($class, $id);
            if ( ! $entity) {
                $errmsg = 'Entity not found!';
                $this->addError($errmsg);
                return $this->jsonResponse(null, 204, $errmsg);
            }
            $this->objectManager->remove($entity);
            $this->objectManager->flush();
            $this->jsonResponse($entity, 200);
        }
    }

    public function patch($class, $id)
    {
        $class = $this->getClass($class);
        if ($this->classExists($class)) {
            $entity = $this->objectManager->find($class, $id);
            if ( ! $entity) {
                $errmsg = 'Entity not found!';
                $this->addError($errmsg);
                return $this->jsonResponse(null, 204, $errmsg);
            }
            $entity = $this->serializer->unserialize($this->getRawInput(), $entity);
            $this->objectManager->flush();
            $this->jsonResponse($entity, 200);
        }
    }
}
