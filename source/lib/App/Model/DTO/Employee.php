<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class Employee extends User
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("boolean")
     */
    protected $isFired;

}
