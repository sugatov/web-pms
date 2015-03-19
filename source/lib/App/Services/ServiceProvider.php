<?php
namespace App\Services;

use CacheInterface;
use StorageInterface;
use MarkdownParser;
use Doctrine\ORM\EntityManagerInterface;
use App\Services;

class ServiceProvider extends \ServiceProvider implements ServiceProviderInterface
{
    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        return $this->serviceLocator['cache'];
    }

    /**
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->serviceLocator['storage'];
    }

    /**
     * @return MarkdownParser
     */
    public function getMarkdownParser()
    {
        return $this->serviceLocator['markdownParser'];
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->serviceLocator['entityManager'];
    }

    /**
     * @return Services\Users
     */
    public function getUsers()
    {
        return $this->serviceLocator['users'];
    }

    /**
     * @return Services\Articles
     */
    public function getArticles()
    {
        return $this->serviceLocator['articles'];
    }

    /**
     * @return Services\Uploads
     */
    public function getUploads()
    {
        return $this->serviceLocator['uploads'];
    }

    /**
     * @return Services\Statistics
     */
    public function getStatistics()
    {
        return $this->serviceLocator['statistics'];
    }
}
