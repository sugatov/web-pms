<?php
namespace App\Controllers;

use \Controller;

class Dev extends Controller
{
    public function input()
    {
        var_dump($this->getRawInput());
    }

    public function hash()
    {
        print_r(hash_algos());
    }

    public function env()
    {
        print_r($this->environment);
    }
}
