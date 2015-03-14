<?php
namespace App;

use ArrayAccess;
use Slim;
use Opensoft\SimpleSerializer\Serializer;
use CacheInterface;
use MarkdownParser;
use StorageInterface;
use App\Services;

class Controller extends \Controller
{
    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var MarkdownParser
     */
    protected $markdown;

    /**
     * @var Services\Users
     */
    protected $users;

    /**
     * @var Services\Articles
     */
    protected $articles;

    /**
     * @var StorageInterface
     */
    protected $storage;

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
        parent::__construct($application, $serializer, $session, $globalViewScope);

        $this->cache    = $cache;
        $this->storage  = $storage;
        $this->markdown = $markdown;
        $this->users    = $users;
        $this->articles = $articles;
    }
}
