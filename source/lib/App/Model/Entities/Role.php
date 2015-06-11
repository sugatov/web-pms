<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Exceptions\ValidationException;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity
 */
class Role extends Super\IntegerID
{
    /**
     * @ORM\Column(type="string", length=16, unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $name = null;

    /**
     * @ORM\ManyToOne(targetEntity="Employee")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\Entities\Employee")
     */
    private $employee;


    /**
     * Set name
     *
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set employee
     *
     * @param \App\Model\Entities\Employee $employee
     * @return Role
     */
    public function setEmployee(\App\Model\Entities\Employee $employee)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \App\Model\Entities\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }
}
