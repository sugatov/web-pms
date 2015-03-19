<?php
namespace App;

use CacheInterface;
use MarkdownParser;
use StorageInterface;
use App\Services;

interface ControllerServiceProviderInterface extends \ControllerServiceProviderInterface
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
