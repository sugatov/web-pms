<?php
namespace App\Controllers;

use App\Controller;

class Dev extends Controller
{
    public function input()
    {
        var_dump($this->getRawInput());
    }

    public function env()
    {
        print_r($this->environment());
    }
}
