<?php

namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentType
 *
 * @ORM\Entity
 */
class PaymentType extends Super\IntegerID
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", unique=true)
     */
    private $name;

    public function __toString()
    {
        return parent::__toString() . ': ' . $this->getName();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return PaymentType
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
}
