<?php

namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Money\Money;

/**
 * Service
 *
 * @ORM\Entity
 * @ORM\InheritanceType(value="JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap(value={
 *     "Service" = "Service",
 *     "Booking" = "Booking",
 *     "ProvidedService" = "ProvidedService"
 *     })
 */
class Service extends Super\IntegerID
{
    /**
     * @var Invoice
     * 
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="services")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $invoice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var Money
     *
     * @ORM\Column(type="money", nullable=false)
     */
    private $price;


    public function __toString()
    {
        $price = $this->getPrice()->getCurrency() . ' ' . $this->getPrice()->getAmount();
        return parent::__toString() .
            ': ' . $this->getDate()->format('d.m.Y H:i:s') .
            ', ' . $price;
    }
    

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Service
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
     * Set price
     *
     * @param money $price
     * @return Service
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
     * Set invoice
     *
     * @param \DomainBundle\Entity\Invoice $invoice
     * @return Service
     */
    public function setInvoice(\DomainBundle\Entity\Invoice $invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return \DomainBundle\Entity\Invoice 
     */
    public function getInvoice()
    {
        return $this->invoice;
    }
}
