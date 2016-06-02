<?php

namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Money\Money;

/**
 * @ORM\Entity
 */
class Payment extends Super\IntegerID
{
    /**
     * @var PaymentType
     * 
     * @ORM\ManyToOne(targetEntity="PaymentType")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $paymentType;

    /**
     * @var Invoice
     * 
     * @ORM\OneToOne(targetEntity="Invoice", inversedBy="payment")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $invoice;

    /**
     * @var Money
     *
     * @ORM\Column(type="money", nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", unique=true, nullable=false)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=10, nullable=true)
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date;


    public function __toString()
    {
        $date = ($this->getDate()) ? $this->getDate()->format('d.m.Y H:i:s') : '☐';
        $price = $this->getPrice()->getCurrency() . ' ' . $this->getPrice()->getAmount();
        return parent::__toString() .
            ': ' . $this->getNumber() .
            ', ' . $price .
            ', ' . $date;
    }
    

    /**
     * Set price
     *
     * @param money $price
     * @return Payment
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
     * Set number
     *
     * @param string $number
     * @return Payment
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
     * Set code
     *
     * @param string $code
     * @return Payment
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Payment
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
     * Set paymentType
     *
     * @param \DomainBundle\Entity\PaymentType $paymentType
     * @return Payment
     */
    public function setPaymentType(\DomainBundle\Entity\PaymentType $paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return \DomainBundle\Entity\PaymentType 
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set invoice
     *
     * @param \DomainBundle\Entity\Invoice $invoice
     * @return Payment
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
