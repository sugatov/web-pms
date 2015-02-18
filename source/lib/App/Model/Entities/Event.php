<?php
namespace App\Model\Entities;

use \App\Model\Exceptions\ValidationException;

/**
 * @Entity
 */
class Event extends Article
{
    /**
     * @Column(type="date", nullable=false)
     */
    private $eventDate;


    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     * @throws ValidationException
     * @return Event
     */
    public function setEventDate($eventDate)
    {
        if (empty($eventDate) || ! $eventDate instanceof \DateTime) {
            throw new ValidationException('Неверный формат даты!');
        }

        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime 
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }
}
