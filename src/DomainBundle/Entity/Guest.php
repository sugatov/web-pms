<?php
namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Guest
 * @package DomainBundle\Entity
 * @ORM\Entity()
 */
class Guest extends Super\IntegerID
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $fullname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Document", mappedBy="guest", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $documents;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="CheckIn", mappedBy="guests")
     */
    private $checkIns;


    public function __toString()
    {
        $birthday = ($this->getBirthday()) ? $this->getBirthday()->format('d.m.Y') : '☐' ;
        return parent::__toString() .
            ': ' . $this->getFullname() .
            ', ' . $birthday;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->checkIns = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     * @return Guest
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string 
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Guest
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Add documents
     *
     * @param \DomainBundle\Entity\Document $documents
     * @return Guest
     */
    public function addDocument(\DomainBundle\Entity\Document $documents)
    {
        $documents->setGuest($this);

        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \DomainBundle\Entity\Document $documents
     */
    public function removeDocument(\DomainBundle\Entity\Document $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Add checkIns
     *
     * @param \DomainBundle\Entity\CheckIn $checkIns
     * @return Guest
     */
    public function addCheckIn(\DomainBundle\Entity\CheckIn $checkIns)
    {
        $this->checkIns[] = $checkIns;

        return $this;
    }

    /**
     * Remove checkIns
     *
     * @param \DomainBundle\Entity\CheckIn $checkIns
     */
    public function removeCheckIn(\DomainBundle\Entity\CheckIn $checkIns)
    {
        $this->checkIns->removeElement($checkIns);
    }

    /**
     * Get checkIns
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCheckIns()
    {
        return $this->checkIns;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Guest
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
