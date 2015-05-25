<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class RussianPassport extends Document
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $serial;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $number;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $issuedBy;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime<Y-m-d>")
     */
    protected $issueDate;
}
