<?php
namespace Opensoft\SimpleSerializer\Metadata\Annotations;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class SinceVersion
{
    /**
     * @Required
     * @var string
     */
    public $value;
}
