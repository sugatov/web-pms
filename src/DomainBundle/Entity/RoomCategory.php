<?php

namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class RoomCategory extends Super\IntegerID
{
    /**
     * @var string
     * 
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private $name;

    /**
     * @var \Money\Money
     * 
     * @ORM\Column(type="money", nullable=false)
     */
    private $price;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=4, unique=false, nullable=false)
     */
    private $class;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Room", mappedBy="roomCategory", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $rooms;


    public function __toString()
    {
        $price = $this->getPrice()->getCurrency() . ' ' . $this->getPrice()->getAmount();
        return parent::__toString() .
            ': ' . $this->getName() .
            ', ' . $this->getClass() .
            ', ' . $price;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rooms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return RoomCategory
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
     * Add rooms
     *
     * @param \DomainBundle\Entity\Room $rooms
     * @return RoomCategory
     */
    public function addRoom(\DomainBundle\Entity\Room $rooms)
    {
        $rooms->setRoomCategory($this);

        $this->rooms[] = $rooms;

        return $this;
    }

    /**
     * Remove rooms
     *
     * @param \DomainBundle\Entity\Room $rooms
     */
    public function removeRoom(\DomainBundle\Entity\Room $rooms)
    {
        $this->rooms->removeElement($rooms);
    }

    /**
     * Get rooms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Set price
     *
     * @param money $price
     * @return RoomCategory
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return money 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set class
     *
     * @param string $class
     * @return RoomCategory
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string 
     */
    public function getClass()
    {
        return $this->class;
    }
}
