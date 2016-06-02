<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Exceptions\ValidationException;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity
 */
class Book extends Service
{
    /**
     * @ORM\Column(type="date", name="Book_firstDay", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime<Y-m-d>")
     */
    private $firstDay;

    /**
     * @ORM\Column(type="date", name="Book_lastDay", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime<Y-m-d>")
     */
    private $lastDay;

    /**
     * @ORM\Column(type="boolean", name="Book_isConfirmed", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("boolean")
     */
    private $isConfirmed = false;

    /**
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\Entities\Room")
     */
    private $room;


    /**
     * Set firstDay
     *
     * @param \DateTime $firstDay
     * @return Book
     */
    public function setFirstDay($firstDay)
    {
        $this->firstDay = $firstDay;

        return $this;
    }

    /**
     * Get firstDay
     *
     * @return \DateTime
     */
    public function getFirstDay()
    {
        return $this->firstDay;
    }

    /**
     * Set lastDay
     *
     * @param \DateTime $lastDay
     * @return Book
     */
    public function setLastDay($lastDay)
    {
        $this->lastDay = $lastDay;

        return $this;
    }

    /**
     * Get lastDay
     *
     * @return \DateTime
     */
    public function getLastDay()
    {
        return $this->lastDay;
    }

    /**
     * Set isConfirmed
     *
     * @param boolean $isConfirmed
     * @return Book
     */
    public function setIsConfirmed($isConfirmed)
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    /**
     * Get isConfirmed
     *
     * @return boolean
     */
    public function getIsConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * Set room
     *
     * @param \App\Model\Entities\Room $room
     * @return Book
     */
    public function setRoom(\App\Model\Entities\Room $room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \App\Model\Entities\Room
     */
    public function getRoom()
    {
        return $this->room;
    }
}
