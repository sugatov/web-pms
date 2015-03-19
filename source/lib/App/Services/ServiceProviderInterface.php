<?php
namespace App\Services;

use CacheInterface;
use StorageInterface;
use MarkdownParser;
use Doctrine\ORM\EntityManagerInterface;
use App\Services;

interface ServiceProviderInterface
{
    /**
     * @return CacheInterface
     */
    public function getCache();
    /**
     * @return StorageInterface
     */
    public function getStorage();
    /**
     * @return MarkdownParser
     */
    public function getMarkdownParser();
    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager();
    /**
     * @return Services\Users
     */
    public function getUsers();
    /**
     * @return Services\Articles
     */
    public function getArticles();
    /**
     * @return Services\Uploads
     */
    public function getUploads();
    /**
     * @return Services\Statistics
     */
    public function getStatistics();
}
