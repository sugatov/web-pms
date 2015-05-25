<?php
namespace App\Model\Entities\Super;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class IntegerID extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id = null;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ID. A hack for serializer
     * @param integer $id identifier
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
