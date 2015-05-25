<?php
namespace App\Model\DTO\Super;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class StringID extends DTO
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $id;
}
