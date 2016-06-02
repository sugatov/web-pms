<?php

namespace DomainBundle\Entity\Super;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class StringID extends Entity
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id = null;

    public function __toString()
    {
        return $this->getId();
    }


    /**
     * Set id
     *
     * @param string $id
     * @return StringID
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
}
