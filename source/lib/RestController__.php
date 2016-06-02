<?php
use Controller;

class RestController extends Controller
{
    private $allowClasses;
    private $disallowClasses;

    public function __construct()
    {
        parent::__construct();
        $this->isJsonResponse();
        $this->serializer->setGroups(array('default'));
        $this->allowClasses = array();
        $this->disallowClasses = array();
    }

    protected function setAllowedClasses($value)
    {
        $this->allowClasses = $value;
    }

    protected function allowClass($class)
    {
        if ( ! in_array($class, $this->allowClasses)) {
            $this->allowClasses[] = $class;
        }
    }

    protected function setDisallowedClasses($value)
    {
        $this->disallowClasses = $value;
    }

    protected function disallowClass($class)
    {
        if ( ! in_array($class, $this->disallowClasses)) {
            $this->disallowClasses[] = $class;
        }
    }

    protected function getClass($class)
    {
        $classname = $this->getService('factory')->getEntityClassname($class);
        if ( ! empty($this->allowClasses)) {
            if ( ! in_array($classname, $this->allowClasses)) {
                throw new \Exception('Доступ к указанному типу сущности не разрешен!');
            }
        }
        if ( ! empty($this->disallowClasses)) {
            if (in_array($classname, $this->disallowClasses)) {
                throw new \Exception('Доступ к указанному типу сущности запрещен!');
            }
        }
        return $classname;
    }

    public function get($class, $id)
    {
        $class = $this->getClass($class);
        $entity = $this->entityManager->find($class, $id);
        if ( ! $entity) {
            throw new \Exception('Сущность не найдена!');
        }
        $this->jsonResponse($entity);
    }

    // используется только для обновления
    public function put($class, $id)
    {
        $class = $this->getClass($class);
        $entity = $this->entityManager->find($class, $id);
        if ( ! $entity) {
            throw new \Exception('Сущность не найдена!');
        }
        $entity = $this->serializer->unserialize($this->jsonRequest(), $entity);
        // $entity = $this->serializer->unserialize($this->jsonRequest(), $class);
        // $this->entityManager->merge($entity);
        $this->entityManager->flush();
        $this->jsonResponse($entity);
    }

    public function post($class)
    {
        $class = $this->getClass($class);
        $entity = new $class;
        $entity = $this->serializer->unserialize($this->jsonRequest(), $entity);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        $this->jsonResponse($entity);
    }

    public function delete($class, $id)
    {
        $class = $this->getClass($class);
        $entity = $this->entityManager->find($class, $id);
        if ( ! $entity) {
            throw new \Exception('Сущность не найдена!');
        }
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
        $this->jsonResponse($entity);
    }
}
