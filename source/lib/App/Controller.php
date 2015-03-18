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
     * @var ControllerServiceProviderInterface
     */
    protected $serviceProvider;

    /**
     * @param Slim\Slim                             $application
     * @param array                                 $globalViewScope    Scope to share through all views
     * @param ControllerServiceProviderInterface    $serviceProvider
     */
    public function __construct(Slim\Slim $application,
                                $globalViewScope,
                                ControllerServiceProviderInterface $serviceProvider)
    {
        parent::__construct($application, $globalViewScope, $serviceProvider);

        $cacheKey = 'articles-event-dates-tree';
        if ($this->cache()->exists($cacheKey, 86400)) {
            $eventDatesTree = unserialize($this->cache()->get($cacheKey));
            $this->globalViewScope['eventDatesTree'] = $eventDatesTree;
        } else {
            $eventDatesTree = $this->prepareEventDatesTree();
            $this->cache()->set($cacheKey, serialize($eventDatesTree));
            $this->globalViewScope['eventDatesTree'] = $eventDatesTree;
        }
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
     * @return Services\Articles
     */
    protected function articles()
    {
        return $this->serviceProvider->getArticles();
    }

    /**
     * @return Services\Uploads
     */
    protected function uploads()
    {
        return $this->serviceProvider->getUploads();
    }

    /**
     * @return array
     */
    protected function prepareEventDatesTree()
    {
        $centuries = $this->articles()->getEventCenturyList();
        foreach ($centuries as &$century) {
            $decades = $this->articles()->getEventDecadeList($century['century']);
            foreach ($decades as &$decade) {
                $years = $this->articles()->getEventYearList($century['century'], $decade['decade']);
                foreach ($years as &$year) {
                    $months = $this->articles()->getEventMonthList($year['year']);
                    $year['months'] = $months;
                    unset($year);
                }
                $decade['years'] = $years;
                unset($decade);
            }
            $century['decades'] = $decades;
            unset($century);
        }
        return $centuries;
    }
}
