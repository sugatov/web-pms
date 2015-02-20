<?php
namespace App\Twig\Extensions;

use Twig_Extension;
use App\Model\Entities\Article;
use App\Model\Entities\Event;
use App\Model\Entities\Location;

class EntityTests extends Twig_Extension
{
    public function getName()
    {
        return 'history-wiki';
    }
    
    public function getTests ()
    {
        return array(
            new \Twig_SimpleTest('Article', function ($entity) {
                return $entity instanceof Article;
            }),
            new \Twig_SimpleTest('Event', function ($entity) {
                return $entity instanceof Event;
            }),
            new \Twig_SimpleTest('Location', function ($entity) {
                return $entity instanceof Location;
            })
        );
    }
}
