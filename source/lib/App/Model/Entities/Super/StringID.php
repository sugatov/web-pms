<?php
namespace App\Model\Entities\Super;

use Doctrine\ORM\Mapping as ORM;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\MappedSuperclass
 */
class StringID extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $id = null;

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
