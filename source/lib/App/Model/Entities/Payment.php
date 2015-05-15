<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;
use App\Model\Exceptions\ValidationException;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=16)
 * @ORM\DiscriminatorMap({
 *     "Payment"         = "Payment",
 *     "Deposit"         = "Deposit",
 *     "AccountPayment"  = "AccountPayment",
 *     "CashPayment"     = "CashPayment",
 *     "CashlessPayment" = "CashlessPayment"
 * })
 */
class Payment extends Super\IntegerID
{
    /**
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $account;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    private $date;
    
    /**
     * @ORM\Column(type="integer", unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=3, unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $currency = 'RUR';

    /**
     * @ORM\OneToOne(targetEntity="Invoice", inversedBy="payment")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $invoice;
    

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
     * Set amount
     *
     * @param integer $amount
     * @return Payment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Payment
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set account
     *
     * @param \App\Model\Entities\Account $account
     * @return Payment
     */
    public function setAccount(\App\Model\Entities\Account $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \App\Model\Entities\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set invoice
     *
     * @param \App\Model\Entities\Invoice $invoice
     * @return Payment
     */
    public function setInvoice(\App\Model\Entities\Invoice $invoice = null)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return \App\Model\Entities\Invoice 
     */
    public function getInvoice()
    {
        return $this->invoice;
    }
}
