<?php
namespace App\Controllers;

use RestController;

class Rest extends RestController
{
    protected function getClass($class)
    {
        return 'App\\Model\\Entities\\' . $class;
    }
}
