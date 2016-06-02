<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Exceptions\ValidationException;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity
 */
class Employee extends User
{
    /**
     * @ORM\Column(type="boolean", name="Employee_isFired", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("boolean")
     */
    private $isFired = false;

    /**
     * @ORM\OneToMany(targetEntity="Role", mappedBy="employee")
     */
    private $roles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set isFired
     *
     * @param boolean $isFired
     * @return Employee
     */
    public function setIsFired($isFired)
    {
        $this->isFired = $isFired;

        return $this;
    }

    /**
     * Get isFired
     *
     * @return boolean
     */
    public function getIsFired()
    {
        return $this->isFired;
    }

    /**
     * Add roles
     *
     * @param \App\Model\Entities\Role $roles
     * @return Employee
     */
    public function addRole(\App\Model\Entities\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \App\Model\Entities\Role $roles
     */
    public function removeRole(\App\Model\Entities\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
