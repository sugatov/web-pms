<?php
namespace App;

use Slim;
use CacheInterface;
use MarkdownParser;
use StorageInterface;
use App\Services;

class Controller extends \Controller
{
    /**
     * @var ServiceProviderInterface
     */
    protected $serviceProvider;

    /**
     * @param Slim\Slim                   $application
     * @param array                       $globalViewScope    Scope to share through all views
     * @param ServiceProviderInterface    $serviceProvider
     */
    public function __construct(Slim\Slim $application,
                                $globalViewScope,
                                ServiceProviderInterface $serviceProvider)
    {
        parent::__construct($application, $globalViewScope, $serviceProvider);
        $this->isJsonResponse(false, 'template.twig');
    }

    /**
     * @return CacheInterface
     */
    protected function cache()
    {
        return $this->serviceProvider->getCache();
    }

    /**
     * @return StorageInterface
     */
    protected function storage()
    {
        return $this->serviceProvider->getStorage();
    }

    /**
     * @return MarkdownParser
     */
    protected function markdownParser()
    {
        return $this->serviceProvider->getMarkdownParser();
    }

    /**
     * @return Services\Users
     */
    protected function users()
    {
        return $this->serviceProvider->getUsers();
    }

    /**
     * @return Services\Uploads
     */
    protected function uploads()
    {
        return $this->serviceProvider->getUploads();
    }
}
