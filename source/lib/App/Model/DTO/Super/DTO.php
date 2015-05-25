<?php
namespace App\Model\DTO\Super;

use Doctrine\ORM\EntityManager;
use App\Model\Entities\Super\Entity;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;
use Doctrine\Common\Annotations\AnnotationReader;

class DTO
{
    /**
     * @var Entity
     * @Serializer\Expose(false)
     */
    protected $entity;

    /**
     * @var EntityManager
     * @Serializer\Expose(false)
     */
    protected $entityManager;

    /**
     * @var AnnotationReader
     */
    protected $annotationReader;

    /**
     * @Serializer\Expose(true)
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


    public function __construct(Entity $entity, EntityManager $entityManager, AnnotationReader $annotationReader)
    {
        $reflectionClass        = new \ReflectionClass($this);
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
        }
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function __call($method, $argv)
    {
        if ( ! $this->entity) {
            throw new \RuntimeException('DTO have no Entity');
        }
        if (in_array(substr($method, 0, 3), array('get', 'set'))) {
            return call_user_func_array(array($this->entity, $method), $argv);
        } else {
            throw new \RuntimeException('Could not call this method: ' . $method);
        }
    }
}
