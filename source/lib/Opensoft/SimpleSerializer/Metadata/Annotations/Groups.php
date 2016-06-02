<?php
namespace Opensoft\SimpleSerializer\Metadata\Annotations;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Groups
{
    /**
     * @Required
     * @var array
     */
    public $value;
}
