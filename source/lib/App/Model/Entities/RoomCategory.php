<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Exceptions\ValidationException;

/**
 * @ORM\Entity
 */
class RoomCategory extends Super\IntegerID
{
    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", unique=false, nullable=false)
     */
    private $price;

    /**
     * @ORM\Column(type="string", unique=false, nullable=false)
     */
    private $designation;

    /**
     * @ORM\OneToMany(targetEntity="Room", mappedBy="roomCategory")
     */
    private $rooms;

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
     * Set price
     *
     * @param integer $price
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
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set designation
     *
     * @param string $designation
     * @return RoomCategory
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Add rooms
     *
     * @param \App\Model\Entities\Room $rooms
     * @return RoomCategory
     */
    public function addRoom(\App\Model\Entities\Room $rooms)
    {
        $this->rooms[] = $rooms;

        return $this;
    }

    /**
     * Remove rooms
     *
     * @param \App\Model\Entities\Room $rooms
     */
    public function removeRoom(\App\Model\Entities\Room $rooms)
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
}
