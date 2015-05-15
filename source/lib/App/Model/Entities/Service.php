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
 *     "Service"      = "Service",
 *     "Book"         = "Book",
 *     "Accomodation" = "Accomodation",
 *     "LocalService" = "LocalService"
 * })
 */
class Service extends Super\IntegerID
{
    /**
     * @ORM\ManyToOne(targetEntity="Invoice")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $invoice;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    private $updated;
    
    /**
     * @ORM\Column(type="string", unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $comment = '';
    
    /**
     * @ORM\Column(type="integer", unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("integer")
     */
    private $price;
    

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Service
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Service
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Service
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
     * Set price
     *
     * @param integer $price
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
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set invoice
     *
     * @param \App\Model\Entities\Invoice $invoice
     * @return Service
     */
    public function setInvoice(\App\Model\Entities\Invoice $invoice)
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
