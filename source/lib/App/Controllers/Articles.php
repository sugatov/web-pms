<?php
namespace App\Controllers;

use ArrayAccess;
use Slim;
use Opensoft\SimpleSerializer\Serializer;
use CacheInterface;
use MarkdownParser;
use StorageInterface;
use App\Services;
use App\Controller;
use App\Model\Entities\Article;

class Articles extends Controller
{
    /**
     * @param Slim\Slim          $application
     * @param Serializer         $serializer
     * @param ArrayAccess        $session
     * @param array              $globalViewScope    Scope to share through all views
     * @param CacheInterface     $cache
     * @param MarkdownParser     $markdown
     * @param Services\Users     $users
     * @param Services\Articles  $articles
     */
    public function __construct(Slim\Slim $application,
                                Serializer $serializer,
                                ArrayAccess $session,
                                $globalViewScope,
                                CacheInterface $cache,
                                StorageInterface $storage,
                                MarkdownParser $markdown,
                                Services\Users $users,
                                Services\Articles $articles)
    {
        parent::__construct($application,
                            $serializer,
                            $session,
                            $globalViewScope,
                            $cache,
                            $storage,
                            $markdown,
                            $users,
                            $articles);
        $this->isJsonResponse(false, 'error.twig');
    }

    protected function prepareForView(Article $article)
    {
        $article->setContent($this->markdown->parse($article->getContent()));
        return $article;
    }
    protected function updateCached($name)
    {
        $cacheKey = 'article#' . $name;
        $article = $this->articles->getLatestVersion($name);
        if ( ! $article) {
            return null;
        }
        $article = $this->prepareForView($article);
        $this->cache->set($cacheKey, serialize($article));
        return $article;
    }

    protected function getCached($name)
    {
        $cacheKey = 'article#' . $name;
        if ($this->cache->exists($cacheKey, 86400)) {
            $article = $this->cache->get($cacheKey);
            $article = unserialize($article);
            return $article;
        } else {
            return $this->updateCached($name);
        }
    }

    public function index()
    {
        $list = null;
        if ( ! $this->cache->exists('articles.latestupdates', 300)) {
            $list = $this->articles->getLatestUpdatesQuery()->getResult();
            $this->cache->set('articles.latestupdates', serialize($list));        
        } else {
            $list = unserialize($this->cache->get('articles.latestupdates'));
        }
        $this->render('index.twig', array('list' => $list));
    }

    public function show($name)
    {
        $article = $this->getCached($name);
        if ($article) {
            $this->render(
                'article.twig',
                array(
                    'article' => $article
                )
            );
        } else {
            $this->render('article-not-found.twig', array('name'=>$name));
        }
    }

    public function preview()
    {
        $this->isJsonResponse(true);
        $articleSerialized = $this->request->post('article');
        $article = new \App\Model\Entities\Article();
        $this->serializer->unserialize($articleSerialized, $article);
        $article = $this->prepareForView($article);
        $this->jsonResponse($article);
    }

    public function create($name='')
    {
        if ( ! $this->request->isPost()) {
            if ( ! empty($name)) {
                $latest = $this->articles->getLatestVersion($name);
                if ($latest) {
                    throw new \Exception('Статья с указанным именем уже существует!');
                }
            }
            $content = $this->storage->read('articles.new.template');
            $article = $this->articles->newArticle();
            $article->setContent($content);
            if ( ! empty($name)) {
                $article->setName($name);
            }
            return $this->render('edit.twig', array(
                'title'=>'Написать статью',
                'article'=>$this->serializer->serialize($article),
                'createMode'=>true
            ));
        } else {
            $user = $this->users->getCurrentUser();
            $input = $this->request->post('article');
            $article = $this->articles->newArticle();
            $this->serializer->unserialize($input, $article);
            switch ($article->getType()) {
                case 'Location':
                    $article = $this->articles->newLocation();
                    $article = $this->serializer->unserialize($input, $article);
                    break;
                case 'Event':
                    $article = $this->articles->newEvent();
                    $article = $this->serializer->unserialize($input, $article);
                    break;
            }
            $this->articles->create($article, $user);
            $this->app->redirect($this->app->urlFor('articles-show', array('name'=>$article->getName())));
        }
    }

    public function edit($id)
    {
        if ( ! $this->request->isPost()) {
            $basedOn = $this->articles->find($id);
            return $this->render('edit.twig', array(
                'title'=>'Редактирование статьи',
                'article'=>$this->serializer->serialize($basedOn),
                'createMode'=>false
            ));
        } else {
            $user = $this->users->getCurrentUser();
            $input = $this->request->post('article');
            $article = $this->articles->newArticle();
            $this->serializer->unserialize($input, $article);
            switch ($article->getType()) {
                case 'Location':
                    $article = $this->articles->newLocation();
                    $article = $this->serializer->unserialize($input, $article);
                    break;
                case 'Event':
                    $article = $this->articles->newEvent();
                    $article = $this->serializer->unserialize($input, $article);
                    break;
            }
            $this->articles->modify($article, $id, $user);
            $this->updateCached($article->getName());
            $this->app->redirect($this->app->urlFor('articles-show', array('name'=>$article->getName())));
        }
    }

    public function versions($name)
    {
        $list = $this->articles->getVersions($name);
        $this->render('versions.twig', array('name'=>$name, 'list'=>$list));
    }

    public function version($id)
    {
        $article = $this->articles->find($id);
        $article = $this->prepareForView($article);
        $this->render(
            'article.twig',
            array(
                'article' => $article
            )
        );
    }

    public function diff($originalId, $newId)
    {
        $original = $this->articles->find($originalId);
        $new = $this->articles->find($newId);
        $difference = $this->articles->compare($original, $new);
        $this->render('diff.twig', array('original'=>$original,
                                         'new'=>$new,
                                         'difference'=>$difference));
    }

    public function all($page=1)
    {
        $list = $this->articles->createNonrecurringQueryBuilder('art')->getQuery()->getResult();
        $this->render('articles.twig', array('title'=>'Все статьи', 'list'=>$list));
    }

    public function locations($page=1)
    {
        $list = $this->articles
                     ->createNonrecurringQueryBuilder('art')
                     ->where('art INSTANCE OF App:Location')
                     ->getQuery()
                     ->getResult();
        $this->render('articles.twig', array('title'=>'Локации', 'list'=>$list));
    }

    public function events($page=1)
    {
        $list = $this->articles
                     ->createNonrecurringQueryBuilder('art')
                     ->where('art INSTANCE OF App:Event')
                     ->getQuery()
                     ->getResult();
        $this->render('articles.twig', array('title'=>'События', 'list'=>$list));
    }

    public function eventsByDate($year=null, $month=null, $day=null)
    {

    }

    public function search()
    {
        $name = $this->request->post('name');
        if ( ! $this->cache->exists("articles.search=$name", 3600)) {
            $list = $this->articles
                         ->createNonrecurringQueryBuilder('art')
                         ->where('art.name LIKE :name')
                         ->setParameter('name', '%'.$name.'%')
                         ->getQuery()
                         ->getResult();
            $this->cache->set("articles.search=$name", serialize($list));
        } else {
            $list = unserialize($this->cache->get("articles.search=$name"));
        }
        $this->render('articles.twig', array('title'=>"Результат поиска по запросу \"$name\"", 'list'=>$list));
    }
}
