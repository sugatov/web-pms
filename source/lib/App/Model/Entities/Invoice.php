<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Exceptions\ValidationException;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity
 */
class Invoice extends Super\IntegerID
{
    /**
     * @ORM\ManyToOne(targetEntity="Check")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\Entities\Check")
     */
    private $check;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("boolean")
     */
    private $isClosed = false;

    /**
     * @ORM\OneToOne(targetEntity="Payment",mappedBy="invoice")
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\Entities\Payment")
     */
    private $payment;


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
     * Set check
     *
     * @param \App\Model\Entities\Check $check
     * @return Invoice
     */
    public function setCheck(\App\Model\Entities\Check $check)
    {
        $this->check = $check;

        return $this;
    }

    /**
     * Get check
     *
     * @return \App\Model\Entities\Check
     */
    public function getCheck()
    {
        return $this->check;
    }

    /**
     * Set payment
     *
     * @param \App\Model\Entities\Payment $payment
     * @return Invoice
     */
    public function setPayment(\App\Model\Entities\Payment $payment = null)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return \App\Model\Entities\Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }
}
