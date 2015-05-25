<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class User extends Super\StringID
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    protected $created;

    /**
     * @Serializer\Expose(false)
     */
    protected $password;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime<Y-m-d>")
     */
    protected $birthday;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $fullname;
}
