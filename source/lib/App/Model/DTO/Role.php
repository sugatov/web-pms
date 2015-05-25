<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class Role extends Super\IntegerID
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\DTO\Employee")
     */
    protected $employee;
    public function getEmployee()
    {
        $val = $this->entity->getEmployee();
        if ($val !== null) {
            $val = new Employee($val, $this->entityManager);
        }
        return $val;
    }
    public function setEmployee($val)
    {
        if ($val instanceof Employee) {
            $this->entityManager->detach($val->getEntity());
            $this->entity->setEmployee($this->entityManager->getReference('App:Employee', $val->getId()));
        }
    }

}
