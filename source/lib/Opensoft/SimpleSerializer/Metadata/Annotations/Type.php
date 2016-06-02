<?php
namespace Opensoft\SimpleSerializer\Metadata\Annotations;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Type
{
    /**
     * @Required
     * @var string
     */
    public $value;
}
