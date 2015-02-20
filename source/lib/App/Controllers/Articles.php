<?php
namespace App\Controllers;

use App\Controller;

class Articles extends Controller
{
    public function show($name)
    {
        $article  = null;
        $cacheKey = 'article#' . $name;
        if ($this->cache->exists($cacheKey, 3600)) {
            $article = $this->cache->get($cacheKey);
            $article = unserialize($article);
        } else {
            $article = $this->articles->getLatestVersion($name);
            if ( ! $article) {
                throw new \RuntimeException('Статья не найдена!');
            }
            $article->setContent($this->markdown->parse($article->getContent()));
            $this->cache->set($cacheKey, serialize($article));
        }
        $this->render(
            'article.twig',
            array(
                'article' => $article
            )
        );
    }
}
