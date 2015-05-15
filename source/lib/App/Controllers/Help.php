<?php
namespace App\Controllers;

use App\Controller;

class Help extends Controller
{
    public function index()
    {
        $title   = 'Помощь';
        $content = null;
        if ( ! $this->cache()->exists('help.index')) {
            $content = $this->storage()->read('help.index');
            $content = $this->markdownParser()->parse($content);
            $this->cache()->set('help.index', $content, 86400);
        } else {
            $content = $this->cache()->get('help.index');
        }
        $this->render('Help/index.twig', array('title'=>$title, 'content'=>$content));
    }
}
