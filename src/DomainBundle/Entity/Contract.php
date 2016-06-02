<?php
namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Contract extends Super\IntegerID
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $number = '0';

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $subject;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $billingAddress;

    /**
     * @var CheckIn
     * @ORM\ManyToOne(targetEntity="CheckIn", inversedBy="contracts")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $checkIn;

    /**
     * @var Invoice
     * @ORM\OneToOne(targetEntity="Invoice", mappedBy="contract", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $invoice;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->setInvoice(new Invoice());
    }

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
     * @return Contract
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
     * @return Contract
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
     * Set subject
     *
     * @param string $subject
     * @return Contract
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set billingAddress
     *
     * @param string $billingAddress
     * @return Contract
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * Get billingAddress
     *
     * @return string 
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Set checkIn
     *
     * @param \DomainBundle\Entity\CheckIn $checkIn
     * @return Contract
     */
    public function setCheckIn(\DomainBundle\Entity\CheckIn $checkIn)
    {
        $this->checkIn = $checkIn;

        return $this;
    }

    /**
     * Get checkIn
     *
     * @return \DomainBundle\Entity\CheckIn 
     */
    public function getCheckIn()
    {
        return $this->checkIn;
    }

    /**
     * Set invoice
     *
     * @param \DomainBundle\Entity\Invoice $invoice
     * @return Contract
     */
    public function setInvoice(\DomainBundle\Entity\Invoice $invoice = null)
    {
        $invoice->setContract($this);

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
