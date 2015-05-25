<?php
/**
 * This file is part of the Simple Serializer.
 *
 * Copyright (c) 2012 Farheap Solutions (http://www.farheap.com)
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Opensoft\SimpleSerializer\Metadata;

/**
 * @author Dmitry Petrov <dmitry.petrov@opensoftdev.ru>
 * @author Evgeny Sugatov
 */
class MyPropertyMetadata extends PropertyMetadata
{
    /**
     * @var boolean
     */
    protected $replace = false;

    /**
     * @param boolean $val
     * @return MyPropertyMetadata
     */
    public function setReplace($val)
    {
        $this->replace = ($val === true) ? true : false;
        return $this;
    }

    /**
     * @return bool
     */
    public function isReplace()
    {
        return $this->replace ? true : false;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->name,
            $this->type,
            $this->serializedName,
            $this->expose,
            $this->groups,
            $this->sinceVersion,
            $this->untilVersion,
            $this->replace
        ));
    }

    /**
     * @param string $str
     * @return MyPropertyMetadata
     */
    public function unserialize($str)
    {
        list($this->name, $this->type, $this->serializedName, $this->expose, $this->groups, $this->sinceVersion, $this->untilVersion, $this->replace) = unserialize($str);

        return $this;
    }
}
