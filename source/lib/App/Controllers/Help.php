<?php
namespace App\Controllers;

use App\Controller;

class Help extends Controller
{
    public function index()
    {
        $title   = 'Помощь';
        $content = null;
        if ( ! $this->cache()->exists('help.index', 300)) {
            $content = $this->storage()->read('help.index');
            $content = $this->markdownParser()->parse($content);
            $this->cache()->set('help.index', $content);
        } else {
            $content = $this->cache()->get('help.index');
        }
        $this->render('help.twig', array('title'=>$title, 'content'=>$content));
    }
}
