<?php
namespace Twig\Extensions;

use \ServiceLocator;

class Filters
{
    public static function register(\Twig_Environment $twig)
    {
        $twig->addFilter(new \Twig_SimpleFilter('count',       'count'));
        $twig->addFilter(new \Twig_SimpleFilter('is_array',    'is_array'));
        $twig->addFilter(new \Twig_SimpleFilter('var_dump',    'var_dump'));
        
        $twig->addFilter(new \Twig_SimpleFilter('paths', array(__CLASS__, 'paths')));
    }

    public static function paths($value)
    {
        $SL = ServiceLocator::getInstance();
        return $SL['fixPaths']($value);
    }
}
