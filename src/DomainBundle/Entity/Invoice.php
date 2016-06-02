<?php
namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Invoice extends Super\IntegerID
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isClosed = false;

    /**
     * @var Contract
     * @ORM\OneToOne(targetEntity="Contract", inversedBy="invoice")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $contract;

    /**
     * @var Payment
     *
     * @ORM\OneToOne(targetEntity="Payment", mappedBy="invoice")
     */
    private $payment;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Service", mappedBy="invoice", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $services;

    public function __toString()
    {
        return parent::__toString();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->services = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set isClosed
     *
     * @param boolean $isClosed
     * @return Invoice
     */
    public function setIsClosed($isClosed)
    {
        $this->isClosed = $isClosed;

        return $this;
    }

    /**
     * Get isClosed
     *
     * @return boolean 
     */
    public function getIsClosed()
    {
        return $this->isClosed;
    }

    /**
     * Set contract
     *
     * @param \DomainBundle\Entity\Contract $contract
     * @return Invoice
     */
    public function setContract(\DomainBundle\Entity\Contract $contract)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * Get contract
     *
     * @return \DomainBundle\Entity\Contract 
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * Set payment
     *
     * @param \DomainBundle\Entity\Payment $payment
     * @return Invoice
     */
    public function setPayment(\DomainBundle\Entity\Payment $payment = null)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return \DomainBundle\Entity\Payment 
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Add services
     *
     * @param \DomainBundle\Entity\Service $services
     * @return Invoice
     */
    public function addService(\DomainBundle\Entity\Service $services)
    {
        $this->services[] = $services;

        return $this;
    }

    /**
     * Remove services
     *
     * @param \DomainBundle\Entity\Service $services
     */
    public function removeService(\DomainBundle\Entity\Service $services)
    {
        $this->services->removeElement($services);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getServices()
    {
        return $this->services;
    }
}
