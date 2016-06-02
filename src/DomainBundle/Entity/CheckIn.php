<?php
namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CheckIn extends Super\IntegerID
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $arrivalDate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $departureDate;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="Guest", inversedBy="checkIns")
     * @ORM\JoinTable(name="checkins_guests")
     */
    private $guests;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Contract", mappedBy="checkIn", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $contracts;

    
    public function __toString()
    {
        $arrival = ($this->getArrivalDate()) ? $this->getArrivalDate()->format('d.m.Y') : '☐';
        $departure = ($this->getDepartureDate()) ? $this->getDepartureDate()->format('d.m.Y') : '☐';
        return parent::__toString() .
            ': ' . $arrival .
            ' — ' . $departure;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contracts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set arrivalDate
     *
     * @param \DateTime $arrivalDate
     * @return CheckIn
     */
    public function setArrivalDate($arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    /**
     * Get arrivalDate
     *
     * @return \DateTime 
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     * Set departureDate
     *
     * @param \DateTime $departureDate
     * @return CheckIn
     */
    public function setDepartureDate($departureDate)
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    /**
     * Get departureDate
     *
     * @return \DateTime 
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return CheckIn
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

    /**
     * Add guests
     *
     * @param \DomainBundle\Entity\Guest $guests
     * @return CheckIn
     */
    public function addGuest(\DomainBundle\Entity\Guest $guests)
    {
        $this->guests[] = $guests;

        return $this;
    }

    /**
     * Remove guests
     *
     * @param \DomainBundle\Entity\Guest $guests
     */
    public function removeGuest(\DomainBundle\Entity\Guest $guests)
    {
        $this->guests->removeElement($guests);
    }

    /**
     * Get guests
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGuests()
    {
        return $this->guests;
    }

    /**
     * Add contracts
     *
     * @param \DomainBundle\Entity\Contract $contracts
     * @return CheckIn
     */
    public function addContract(\DomainBundle\Entity\Contract $contracts)
    {
        $contracts->setCheckIn($this);
        
        $this->contracts[] = $contracts;

        return $this;
    }

    /**
     * Remove contracts
     *
     * @param \DomainBundle\Entity\Contract $contracts
     */
    public function removeContract(\DomainBundle\Entity\Contract $contracts)
    {
        $this->contracts->removeElement($contracts);
    }

    /**
     * Get contracts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContracts()
    {
        return $this->contracts;
    }
}
