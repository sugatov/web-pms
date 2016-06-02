<?php
namespace App\Controllers;

use App\Controller;

class Manager extends Controller
{
    public function index()
    {
        $this->render('index.twig');
    }
}
