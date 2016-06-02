<?php
use Slim\Slim;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Opensoft\SimpleSerializer\Serializer;
use Rs\Json\Patch as JsonPatch;

abstract class RestController extends Controller
{
    const STRICT_MODE        = 2;
    const MEDIUM_STRICT_MODE = 1;
    const NON_STRICT_MODE    = 0;

    /**
     * @var ObjectManager
     */
    protected $objectManager;
    /**
     * @var Serializer
     */
    protected $serializer;

    public function __construct(Slim $application,
                                array $globalViewScope,
                                ServiceProviderInterface $serviceProvider,
                                ObjectManager $objectManager)
    {
        parent::__construct($application, $globalViewScope, $serviceProvider);

        $this->objectManager    = $objectManager;
        $this->serializer       = $serviceProvider->getSerializer();
    }

    abstract protected function getClass($class);

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
        $fqcn = $this->getClass($class);
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
                     ->from($fqcn, 'e');
            if ($criteria) {
                foreach ($criteria as $property => $value) {
                    $qb->andWhere('e.' . $property . ' = :' . $property)
                       ->setParameter($property, $value);
                }
            }
            $cnt = $qb->getQuery()->getSingleScalarResult();
        } else {
            $rep = $this->objectManager->getRepository($fqcn);
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
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $list = $this->findBy($fqcn, array(), $limit, $offset, $orderBy, $desc);
            $this->jsonResponse($list, 200);
        }
    }

    public function find($class, $limit = null, $offset = null, $orderBy = null, $desc = false)
    {
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $criteria = $this->serializer->unserialize($this->getRawInput());
            $list = $this->findBy($fqcn, $criteria, $limit, $offset, $orderBy, $desc);
            $this->jsonResponse($list, 200);
        }
    }

    public function getNew($class)
    {
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $entity = new $fqcn();
            $this->jsonResponse($entity, 200);
        }
    }

    public function get($class, $id)
    {
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $entity = $this->objectManager->find($fqcn, $id);
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
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $entity = new $fqcn();
            $this->serializer->setUnserializeMode(self::MEDIUM_STRICT_MODE);
            $entity = $this->serializer->unserialize($this->getRawInput(), $entity);
            $this->objectManager->merge($entity);
            $this->objectManager->flush();
            $this->jsonResponse($entity, 201);
        }
    }

    public function put($class, $id)
    {
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $entity = new $fqcn();
            $this->serializer->setUnserializeMode(self::STRICT_MODE);
            $entity = $this->serializer->unserialize($this->getRawInput(), $entity);
            $this->objectManager->merge($entity);
            $this->objectManager->flush();
            $this->jsonResponse($entity, 200);
        }
    }

    public function delete($class, $id)
    {
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $entity = $this->objectManager->find($fqcn, $id);
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
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $entity = $this->objectManager->find($fqcn, $id);
            if ( ! $entity) {
                $errmsg = 'Entity not found!';
                $this->addError($errmsg);
                return $this->jsonResponse(null, 204, $errmsg);
            }
            $this->objectManager->detach($entity);
            $this->serializer->setUnserializeMode(self::MEDIUM_STRICT_MODE);
            $source = $this->serializer->serialize($entity);
            $patch = new JsonPatch($source, $this->getRawInput());
            $patched = $patch->apply();
            $entity = new $fqcn();
            $entity = $this->serializer->unserialize($patched, $entity);
            $this->objectManager->merge($entity);
            $this->objectManager->flush();
            $this->jsonResponse($entity, 200);
        }
    }
}
