<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=16)
 * @ORM\DiscriminatorMap({
 *     "Document" = "Document",
 *     "RussianPasport" = "RussianPasport"
 * })
 * 
 */
class Document extends Super\IntegerID
{
    /**
     * @ORM\Column(type="string", unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $data = '';
    
    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $customer;
    

    /**
     * Set name
     *
     * @param string $name
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
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
     * Set customer
     *
     * @param \App\Model\Entities\Customer $customer
     * @return Document
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
}
