<?php
namespace App\Model\DTO\Super;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class IntegerID extends DTO
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("integer")
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
