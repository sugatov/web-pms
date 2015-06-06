<?php
namespace App\Model\DTO\Super;

use Doctrine\ORM\EntityManager;
use App\Model\Entities\Super\Entity;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;
use Doctrine\Common\Annotations\AnnotationReader;

define('DTO_NULL', '__NULL__');

class DTO
{
    /**
     * @Serializer\Expose(false)
     * @Serializer\Type("string")
     */
    protected $class;
    public function getClass()
    {
        return $this->class;
    }
    public function setClass($val)
    {
        $this->class = $val;
    }

    protected function getEntityClass($class)
    {
        return 'App\\Model\Entities\\' . $class;
    }

    /**
     * @Serializer\Expose(false)
     */
    protected $entity = null;

    /**
     * @Serializer\Expose(false)
     * @var EntityManager
     */
    protected $entityManager = null;


    // public function __construct(Entity $entity, EntityManager $entityManager, AnnotationReader $annotationReader)
    public function __construct(EntityManager $entityManager, $id = null)
    {
        $this->entityManager = $entityManager;
        $reflectionClass     = new \ReflectionClass($this);
        $class               = $reflectionClass->getShortName();
        $this->class         = $class;
        $entityClass         = $this->getEntityClass($class);
        if ($id !== null && $id !== 0) {
            $this->entity = $this->entityManager->find($entityClass, $id);
        }
        if ($id === 0) {
            $this->entity = new $entityClass();
        }

        /*$reflectionClass        = new \ReflectionClass($this);
        $this->class            = $reflectionClass->getShortName();
        $this->entity           = $entity;
        $this->entityManager    = $entityManager;
        $this->annotationReader = $annotationReader;
        foreach ($reflectionClass->getProperties() as $property) {
            $name = $property->getName();
            $annotations = $this->annotationReader->getPropertyAnnotations($property);
            foreach ($annotations as $annotation) {
                if (
                    $annotation instanceof Serializer\Type
                    && class_exists($annotation->value)
                    && is_a($annotation->value, 'App\\Model\\DTO\\Super\\DTO', true)
                ) {
                    $rc = new \ReflectionClass($annotation->value);
                    $entityClass = 'App\\Model\\Entities\\' . $rc->getShortName();
                    $instance = new $annotation->value(new $entityClass, $entityManager, $annotationReader);
                    $this->$name = $instance;
                }
            }
        }*/
    }

    public function save(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $reflectionClass     = new \ReflectionClass($this);
        $class               = $reflectionClass->getShortName();
        $this->class         = $class;
        $entityClass         = $this->getEntityClass($class);

        //
    }
}
