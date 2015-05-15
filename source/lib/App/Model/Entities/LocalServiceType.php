<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;
use App\Model\Exceptions\ValidationException;

/**
 * @ORM\Entity
 */
class LocalServiceType extends Super\IntegerID
{
    /**
     * @ORM\Column(type="string", unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $name;
    
    /**
     * @ORM\Column(type="integer", unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("integer")
     */
    private $price;
    
    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("boolean")
     */
    private $isAvailable = true;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    private $created;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    private $updated;
    

    /**
     * Set name
     *
     * @param string $name
     * @return LocalServiceType
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
     * Set price
     *
     * @param integer $price
     * @return LocalServiceType
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isAvailable
     *
     * @param boolean $isAvailable
     * @return LocalServiceType
     */
    public function setIsAvailable($isAvailable)
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * Get isAvailable
     *
     * @return boolean 
     */
    public function getIsAvailable()
    {
        return $this->isAvailable;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return LocalServiceType
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return LocalServiceType
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
