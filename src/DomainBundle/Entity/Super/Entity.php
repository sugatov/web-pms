<?php

namespace DomainBundle\Entity\Super;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class Entity
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @ORM\PrePersist
     */
    public function Entity_prePersist()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function Entity_preUpdate()
    {
        $this->updated = new \DateTime();
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Entity
     * @throws \Exception
     */
    public function setCreated($created)
    {
        throw new \Exception('This property should not be changed anywhere!');

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
     * @return Entity
     * @throws \Exception
     */
    public function setUpdated($updated)
    {
        throw new \Exception('This property should not be changed anywhere!');

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
}
