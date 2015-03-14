<?php
namespace App;

class Controller extends \Controller
{
    /**
     * @var ControllerServiceProviderInterface
     */
    protected $serviceProvider;

    protected function cache()
    {
        return $this->serviceProvider->getCache();
    }

    protected function storage()
    {
        return $this->serviceProvider->getStorage();
    }

    protected function markdownParser()
    {
        return $this->serviceProvider->getMarkdownParser();
    }

    protected function users()
    {
        return $this->serviceProvider->getUsers();
    }

    protected function articles()
    {
        return $this->serviceProvider->getArticles();
    }

    protected function uploads()
    {
        return $this->serviceProvider->getUploads();
    }
}
