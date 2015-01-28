<?php
namespace Hotel\Controllers;

use \Hotel\Controller;

class MngHome extends Controller
{
    public function index()
    {
        $this->render('mng/index.twig');
    }
} 