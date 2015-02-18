<?php
namespace App\Services;

use \RepositoryBasedService;
use \Doctrine\Common\Persistence\ObjectManager;
use \TextCompareInterface;
use \App\Model\Entities\Article;
use \App\Model\Entities\Event;
use \App\Model\Entities\Location;
use \App\Model\Entities\User;


class Articles extends RepositoryBasedService
{
    /**
     * @var \App\Model\Repositories\Articles
     */
    protected $repository;

    /**
     * @var TextCompareInterface
     */
    protected $compareTool;

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager, TextCompareInterface $compareTool)
    {
        parent::__construct($objectManager, 'App:Article');

        $this->compareTool = $compareTool;
    }

    /**
     * Create an instance of Article
     * @return \App\Model\Entities\Article
     */
    public function newArticle()
    {
        return new Article();
    }

    /**
     * Create an instance of Event
     * @return \App\Model\Entities\Event
     */
    public function newEvent()
    {
        return new Event();
    }

    /**
     * Create an instance of Location
     * @return \App\Model\Entities\Location
     */
    public function newLocation()
    {
        return new Location();
    }

    /**
     * Create an article
     * @param  Article $new
     * @param  User    $user
     * @return Article
     * @throws \Exception
     */
    public function create(Article $new, User $user)
    {
        $name = $new->getName();
        $latest = $this->repository->getLatestVersion($name);
        if ($latest) {
            throw new \Exception('Статья с указанным именем уже существует!');
        }
        $new->setUser($user);
        $this->objectManager->persist($new);
        $this->objectManager->flush();
        return $new;
    }

    /**
     * Modify existing article
     * @param  Article      $new
     * @param  Article|int  $old
     * @param  User         $user
     * @return Article
     * @throws \Exception
     */
    public function modify(Article $new, $old, User $user)
    {
        if ( ! $old instanceof Article && is_int($old)) {
            $old = $this->repository->find($old);
        }
        if ( ! $old) {
            throw new \Exception('Неправильный идентификатор предыдущей версии статьи!');
        }
        $new->setUser($user);
        $new->setBasedOn($old);
        $this->objectManager->persist($new);
        $this->objectManager->flush();
        return $new;
    }

    /**
     * Compare two articles
     * @param  Article $original
     * @param  Article $new
     * @return string
     */
    public function compare(Article $original, Article $new)
    {
        $originalName = $original->getName() . ' ' . $original->getDate()->format('d.m.Y H:i:s');
        $originalText = $original->getContent();
        if ($original instanceof Event) {
            $originalText = 'Дата события: ' . $original->getEventDate()->format('d.m.Y') . "\n" . $originalText;
        }
        $newName = $new->getName() . ' ' . $new->getDate()->format('d.m.Y H:i:s');
        $newText = $new->getContent();
        if ($new instanceof Event) {
            $newText = 'Дата события: ' . $new->getEventDate()->format('d.m.Y') . "\n" . $newText;
        }
        return $this->compareTool->compare($originalText, $newText, $originalName, $newName);
    }
}
