<?php
namespace App;

class ServiceProvider extends \ServiceProvider implements ServiceProviderInterface
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

    public function getUploads()
    {
        return $this->serviceLocator['uploads'];
    }

}
