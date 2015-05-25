<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Exceptions\ValidationException;

/**
 * @ORM\Entity
 */
class Account extends Super\IntegerID
{
    /**
     * @ORM\OneToOne(targetEntity="Customer",inversedBy="account")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity="Payment", mappedBy="account")
     */
    private $payments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->payments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set customer
     *
     * @param \App\Model\Entities\Customer $customer
     * @return Account
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
     * Add payments
     *
     * @param \App\Model\Entities\Payment $payments
     * @return Account
     */
    public function addPayment(\App\Model\Entities\Payment $payments)
    {
        $this->payments[] = $payments;

        return $this;
    }

    /**
     * Remove payments
     *
     * @param \App\Model\Entities\Payment $payments
     */
    public function removePayment(\App\Model\Entities\Payment $payments)
    {
        $this->payments->removeElement($payments);
    }

    /**
     * Get payments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayments()
    {
        return $this->payments;
    }
}
