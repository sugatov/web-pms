<?php
namespace App;

class ControllerServiceProvider extends \ControllerServiceProvider implements ControllerServiceProviderInterface
{
    public function getCache()
    {
        return $this->serviceLocator['cache'];
    }

    public function getStorage()
    {
        return $this->serviceLocator['storage'];
    }

    public function getMarkdownParser()
    {
        return $this->serviceLocator['markdownParser'];
    }

    public function getUsers()
    {
        return $this->serviceLocator['users'];
    }

    public function getArticles()
    {
        return $this->serviceLocator['articles'];
    }

    public function getUploads()
    {
        return $this->serviceLocator['uploads'];
    }

    public function getStatistics()
    {
        return $this->serviceLocator['statistics'];
    }
}
