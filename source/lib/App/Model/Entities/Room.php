<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Exceptions\ValidationException;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity
 */
class Room extends Super\IntegerID
{
    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("boolean")
     */
    private $isAvailable = true;

    /**
     * @ORM\ManyToOne(targetEntity="RoomCategory")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\Entities\RoomCategory")
     */
    private $roomCategory;



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
     * @param \App\Model\Entities\RoomCategory $roomCategory
     * @return Room
     */
    public function setRoomCategory(\App\Model\Entities\RoomCategory $roomCategory)
    {
        $this->roomCategory = $roomCategory;

        return $this;
    }

    /**
     * Get roomCategory
     *
     * @return \App\Model\Entities\RoomCategory
     */
    public function getRoomCategory()
    {
        return $this->roomCategory;
    }
}
