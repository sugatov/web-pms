<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class Upload extends Super\IntegerID
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $filename;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $originalFilename;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $mimeType;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $tag;
}
