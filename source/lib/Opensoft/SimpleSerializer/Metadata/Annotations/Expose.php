<?php
namespace Opensoft\SimpleSerializer\Metadata\Annotations;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Expose
{
    /**
     * @Required
     * @var bool
     */
    public $value;
}
