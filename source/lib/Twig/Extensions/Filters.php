<?php
namespace Twig\Extensions;

use Twig_Extension;
use Twig_SimpleFilter;

class Filters extends Twig_Extension
{
    public function getName()
    {
        return 'history-wiki-dev-filters';
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('count',      'count'),
            new Twig_SimpleFilter('is_array',   'is_array'),
            new Twig_SimpleFilter('var_dump',   'var_dump'),
            new Twig_SimpleFilter('print_r',    'print_r')
        );
    }
}
