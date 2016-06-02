<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Exceptions\ValidationException;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity(repositoryClass="\App\Model\Repositories\Users")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=16)
 * @ORM\DiscriminatorMap({
 *     "User" = "User",
 *     "Employee" = "Employee",
 *     "Customer" = "Customer"
 * })
 */
class User extends Super\StringID
{
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    private $created;

    /**
     * @ORM\Column(type="string", unique=false, nullable=false)
     * @Serializer\Expose(false)
     */
    private $password;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime<Y-m-d>")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", unique=false, nullable=true)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $fullname;


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     * @return User
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }
}
