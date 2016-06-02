<?php

namespace DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProvidedService
 *
 * @ORM\Entity
 */
class ProvidedService extends Service
{
    /**
     * @var ProvidedServiceType
     *
     * @ORM\ManyToOne(targetEntity="ProvidedServiceType")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $providedServiceType;
    

    /**
     * Set providedServiceType
     *
     * @param ProvidedServiceType $providedServiceType
     * @return ProvidedService
     */
    public function setProvidedServiceType(ProvidedServiceType $providedServiceType)
    {
        $this->providedServiceType = $providedServiceType;

        return $this;
    }

    /**
     * Get providedServiceType
     *
     * @return ProvidedServiceType
     */
    public function getProvidedServiceType()
    {
        return $this->providedServiceType;
    }
}
