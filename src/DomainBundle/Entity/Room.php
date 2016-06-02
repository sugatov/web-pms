<?php

namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Room extends Super\IntegerID
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isAvailable = true;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @var RoomCategory
     *
     * @ORM\ManyToOne(targetEntity="RoomCategory")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $roomCategory;


    public function __toString()
    {
        $status = ($this->getIsAvailable()) ? '✓' : '✕';
        return parent::__toString() .
            ': ' . $this->getName() .
            ', ' . $status;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Room
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
     * Set isAvailable
     *
     * @param boolean $isAvailable
     * @return Room
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
     * Set roomCategory
     *
     * @param \DomainBundle\Entity\RoomCategory $roomCategory
     * @return Room
     */
    public function setRoomCategory(\DomainBundle\Entity\RoomCategory $roomCategory)
    {
        $this->roomCategory = $roomCategory;

        return $this;
    }

    /**
     * Get roomCategory
     *
     * @return \DomainBundle\Entity\RoomCategory 
     */
    public function getRoomCategory()
    {
        return $this->roomCategory;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Room
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }
}
