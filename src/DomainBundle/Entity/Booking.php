<?php

namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(name="bookingDate_room", columns={"bookingDate", "room_id"})
 * })
 */
class Booking extends Service
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="bookingDate")
     */
    private $bookingDate;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false, name="room_id")
     */
    private $room;

    public function __toString()
    {
        return parent::__toString() .
            ': ' . $this->getBookingDate()->format('d.m.Y');
    }


    /**
     * Set bookingDate
     *
     * @param \DateTime $bookingDate
     * @return Booking
     */
    public function setBookingDate($bookingDate)
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    /**
     * Get bookingDate
     *
     * @return \DateTime 
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }

    /**
     * Set room
     *
     * @param \DomainBundle\Entity\Room $room
     * @return Booking
     */
    public function setRoom(\DomainBundle\Entity\Room $room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \DomainBundle\Entity\Room 
     */
    public function getRoom()
    {
        return $this->room;
    }
}
