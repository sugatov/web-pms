<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Exceptions\ValidationException;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity
 */
class Check extends Super\IntegerID
{
    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\Entities\Customer")
     */
    private $customer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    private $checkInDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    private $checkOutDate;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $comment = '';

    /**
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="check")
     */
    private $invoices;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set checkInDate
     *
     * @param \DateTime $checkInDate
     * @return Check
     */
    public function setCheckInDate($checkInDate)
    {
        $this->checkInDate = $checkInDate;

        return $this;
    }

    /**
     * Get checkInDate
     *
     * @return \DateTime
     */
    public function getCheckInDate()
    {
        return $this->checkInDate;
    }

    /**
     * Set checkOutDate
     *
     * @param \DateTime $checkOutDate
     * @return Check
     */
    public function setCheckOutDate($checkOutDate)
    {
        $this->checkOutDate = $checkOutDate;

        return $this;
    }

    /**
     * Get checkOutDate
     *
     * @return \DateTime
     */
    public function getCheckOutDate()
    {
        return $this->checkOutDate;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Check
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
     * Set customer
     *
     * @param \App\Model\Entities\Customer $customer
     * @return Check
     */
    public function setCustomer(\App\Model\Entities\Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \App\Model\Entities\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Add invoices
     *
     * @param \App\Model\Entities\Invoice $invoices
     * @return Check
     */
    public function addInvoice(\App\Model\Entities\Invoice $invoices)
    {
        $this->invoices[] = $invoices;

        return $this;
    }

    /**
     * Remove invoices
     *
     * @param \App\Model\Entities\Invoice $invoices
     */
    public function removeInvoice(\App\Model\Entities\Invoice $invoices)
    {
        $this->invoices->removeElement($invoices);
    }

    /**
     * Get invoices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoices()
    {
        return $this->invoices;
    }
}
