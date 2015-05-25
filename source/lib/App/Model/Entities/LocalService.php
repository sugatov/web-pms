<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Exceptions\ValidationException;

/**
 * @ORM\Entity
 */
class LocalService extends Service
{
    /**
     * @ORM\ManyToOne(targetEntity="LocalServiceType")
     * @ORM\JoinColumn(referencedColumnName="id", name="LocalService_type", nullable=false)
     */
    private $type;


    /**
     * Set type
     *
     * @param \App\Model\Entities\LocalServiceType $type
     * @return LocalService
     */
    public function setType(\App\Model\Entities\LocalServiceType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \App\Model\Entities\LocalServiceType
     */
    public function getType()
    {
        return $this->type;
    }
}
