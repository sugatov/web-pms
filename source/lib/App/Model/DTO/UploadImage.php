<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class UploadImage extends Upload
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("integer")
     */
    protected $width;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("integer")
     */
    protected $height;
}
