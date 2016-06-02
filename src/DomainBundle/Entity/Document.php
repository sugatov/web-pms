<?php

namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Document extends Super\IntegerID
{
    /**
     * @var Guest
     * @ORM\ManyToOne(targetEntity="Guest", inversedBy="documents")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $guest;
    
    /**
     * @ORM\ManyToOne(targetEntity="DocumentType")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $documentType;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $number;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="text", unique=false, nullable=true)
     */
    private $data = '';

    public function __toString()
    {
        $date = ($this->getDate()) ? $this->getDate()->format('d.m.Y') : '☐';
        return parent::__toString() .
            ': ' . $this->getNumber() .
            ', ' . $date;
    }


    /**
     * Set number
     *
     * @param string $number
     * @return Document
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Document
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set data
     *
     * @param string $data
     * @return Document
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set guest
     *
     * @param \DomainBundle\Entity\Guest $guest
     * @return Document
     */
    public function setGuest(\DomainBundle\Entity\Guest $guest)
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * Get guest
     *
     * @return \DomainBundle\Entity\Guest 
     */
    public function getGuest()
    {
        return $this->guest;
    }

    /**
     * Set documentType
     *
     * @param \DomainBundle\Entity\DocumentType $documentType
     * @return Document
     */
    public function setDocumentType(\DomainBundle\Entity\DocumentType $documentType)
    {
        $this->documentType = $documentType;

        return $this;
    }

    /**
     * Get documentType
     *
     * @return \DomainBundle\Entity\DocumentType 
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }
}
