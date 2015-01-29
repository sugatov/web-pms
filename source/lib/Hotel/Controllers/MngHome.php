<?php
namespace Hotel\Controllers;

use \Controller;

class MngHome extends Controller
{
    public function index()
    {
        $this->render('mng/index.twig');
    }
} 
