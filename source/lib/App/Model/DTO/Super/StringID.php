<?php
namespace App\Model\DTO\Super;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class StringID extends DTO
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    public $id;

    public function __construct($entityManager, $id)
    {
        parent::__construct($entityManager, $id);

        if ($this->entity) {
            $this->id = $this->entity->getId();
        }
    }
}
