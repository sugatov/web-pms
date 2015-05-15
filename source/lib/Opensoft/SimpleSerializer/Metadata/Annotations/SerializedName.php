<?php
namespace Opensoft\SimpleSerializer\Metadata\Annotations;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class SerializedName
{
    /**
     * @Required
     * @var string
     */
    public $value;
}
