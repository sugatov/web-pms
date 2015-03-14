<?php
namespace App\Model\Entities;

use \App\Model\Exceptions\ValidationException;

/**
 * @Entity
 * @HasLifecycleCallbacks
 */
class Event extends Article
{
    /**
     * @Column(type="date", nullable=false)
     */
    private $eventDate;

    /**
     * @PrePersist
     * @PreUpdate
     */
    public function _prePersist()
    {
        parent::_prePersist();
        if (empty($this->eventDate)) {
            throw new ValidationException('Неверный формат даты!');
        }
    }


    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     * @throws ValidationException
     * @return Event
     */
    public function setEventDate($eventDate)
    {
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
