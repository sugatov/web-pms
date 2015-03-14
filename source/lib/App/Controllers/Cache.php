<?php
namespace App\Controllers;

use Slim;
use Opensoft\SimpleSerializer\Serializer;
use ArrayAccess;
use Controller;

class Cache extends Controller
{
    /**
     * @var ArrayAccess
     */
    protected $ServiceLocator;

    /**
     * @param Slim\Slim     $application
     * @param Serializer    $serializer
     * @param ArrayAccess   $session
     * @param array         $globalViewScope    Scope to share through all views
     * @param ArrayAccess   $ServiceLocator
     */
    public function __construct(Slim\Slim $application,
                                Serializer $serializer,
                                ArrayAccess $session,
                                $globalViewScope,
                                ArrayAccess $ServiceLocator)
    {
        parent::__construct($application, $serializer, $session, $globalViewScope);
        $this->ServiceLocator = $ServiceLocator;
    }

    public function show($name)
    {
        $article  = null;
        $cacheKey = 'article#' . $name;
        if ($this->ServiceLocator['cache']->exists($cacheKey, 3600)) {
            $article = $this->ServiceLocator['cache']->get($cacheKey);
            $article = unserialize($article);
        } else {
            $article = $this->ServiceLocator['articles']->getLatestVersion($name);
            if ( ! $article) {
                return $this->render('article-not-found.twig', array('name'=>$name));
            }
            $article->setContent($this->markdown->parse($article->getContent()));
            $this->ServiceLocator['cache']->set($cacheKey, serialize($article));
        }
        $this->render(
            'article.twig',
            array(
                'article' => $article
            )
        );
    }
}
