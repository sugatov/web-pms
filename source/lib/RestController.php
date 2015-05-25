<?php
use Slim\Slim;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;
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
    /**
     * @var AnnotationReader
     */
    protected $annotationReader;

    public function __construct(Slim $application, ObjectManager $objectManager, Serializer $serializer, AnnotationReader $annotationReader, array $globalViewScope, ServiceProviderInterface $serviceProvider)
    {
        parent::__construct($application, $globalViewScope, $serviceProvider);

        $this->application      = $application;
        $this->objectManager    = $objectManager;
        $this->serializer       = $serializer;
        $this->annotationReader = $annotationReader;
    }

    protected function getClass($class)
    {
        return 'App\\Model\\Entities\\' . $class;
    }

    protected function getDTOClass($class)
    {
        return 'App\\Model\\DTO\\' . $class;
    }

    protected function haveDTO($class)
    {
        return class_exists($this->getDTOClass($class));
    }

    protected function makeDTO($class, $set) {
        if ( ! $this->haveDTO($class)) {
            return $set;
        }
        $fqcn = $this->getDTOClass($class);
        if (($set instanceof \ArrayAccess) || is_array($set)) {
            foreach ($set as &$obj) {
                // $obj = new $fqcn($obj, $this->objectManager);
                $obj = new $fqcn($obj, $this->objectManager, $this->annotationReader);
                unset($obj);
            }
        } else {
            // $set = new $fqcn($set, $this->objectManager);
            $set = new $fqcn($set, $this->objectManager, $this->annotationReader);
        }
        return $set;
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
            $list = $this->makeDTO($class, $list);
            $this->jsonResponse($list, 200);
        }
    }

    public function find($class, $limit = null, $offset = null, $orderBy = null, $desc = false)
    {
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $criteria = $this->serializer->unserialize($this->getRawInput());
            $list = $this->findBy($fqcn, $criteria, $limit, $offset, $orderBy, $desc);
            $list = $this->makeDTO($class, $list);
            $this->jsonResponse($list, 200);
        }
    }

    public function getNew($class)
    {
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $entity = new $fqcn();
            $entity = $this->makeDTO($class, $entity);
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
            $entity = $this->makeDTO($class, $entity);
            $this->jsonResponse($entity, 200);
        }
    }

    public function post($class)
    {
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $entity = new $fqcn();
            if ($this->haveDTO($class)) {
                $dtofqcn = $this->getDTOClass($class);
                // $entity = new $dtofqcn($entity, $this->objectManager);
                $entity = new $dtofqcn($entity, $this->objectManager, $this->annotationReader);
            }
            $entity = $this->serializer->unserialize($this->getRawInput(), $entity);
            if ($this->haveDTO($class)) {
                $this->objectManager->persist($entity->getEntity());
            } else {
                $this->objectManager->persist($entity);
            }
            $this->objectManager->flush();
            $this->jsonResponse($entity, 201);
        }
    }

    // используется только для обновления
    public function put($class, $id)
    {
        $fqcn = $this->getClass($class);
        if ($this->classExists($fqcn)) {
            $entity = $this->objectManager->find($fqcn, $id);
            // $entity = $this->objectManager->getReference($fqcn, $id);
            if ( ! $entity) {
                $errmsg = 'Entity not found!';
                $this->addError($errmsg);
                return $this->jsonResponse(null, 204, $errmsg);
            }
            $entity = $this->makeDTO($class, $entity);
            $entity = $this->serializer->unserialize($this->getRawInput(), $entity);
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
            $entity = $this->makeDTO($class, $entity);
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
            $entity = $this->makeDTO($class, $entity);
            $entity = $this->serializer->unserialize($this->getRawInput(), $entity);
            $this->objectManager->flush();
            $this->jsonResponse($entity, 200);
        }
    }
}
