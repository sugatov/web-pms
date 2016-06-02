<?php

namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Money\Money;

/**
 * ProvidedServiceType
 *
 * @ORM\Entity
 */
class ProvidedServiceType extends Super\IntegerID
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var Money
     * 
     * @ORM\Column(type="money", nullable=false)
     */
    private $price;

    public function __toString()
    {
        $price = $this->getPrice()->getCurrency() . ' ' . $this->getPrice()->getAmount();
        return parent::__toString() .
            ': ' . $this->getName() .
            ', ' . $price;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return ProvidedServiceType
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
     * Set price
     *
     * @param money $price
     * @return ProvidedServiceType
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
}
