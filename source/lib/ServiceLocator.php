<?php
use \Pimple\Container as Pimple;

final class ServiceLocator
{
    private static $__instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (null === self::$__instance) {
            self::$__instance = new Pimple();
        }
        return self::$__instance;
    }
}
