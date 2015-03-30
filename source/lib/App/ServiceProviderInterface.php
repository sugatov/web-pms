<?php
namespace App;

use CacheInterface;
use MarkdownParser;
use StorageInterface;
use App\Services;

interface ServiceProviderInterface extends \ServiceProviderInterface
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
     * @return Services\Uploads
     */
    public function getUploads();
}
