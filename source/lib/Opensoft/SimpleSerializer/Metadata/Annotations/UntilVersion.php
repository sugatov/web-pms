<?php
namespace Opensoft\SimpleSerializer\Metadata\Annotations;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class UntilVersion
{
    /**
     * @Required
     * @var string
     */
    public $value;
}
