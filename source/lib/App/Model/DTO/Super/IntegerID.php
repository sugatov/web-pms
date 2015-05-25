<?php
namespace App\Model\DTO\Super;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class IntegerID extends DTO
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("integer")
     */
    protected $id;
}
