<?php
namespace App\Services;

use Service;
use StorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\Entities\ArticleView;

class Statistics extends Service
{
    const SHOWSTATS_STORAGE_NAME = 'articles.showstats';
    const POPULAR_TODAY_STORAGE_NAME = 'articles.popular.today';
    const POPULAR_WEEK_STORAGE_NAME = 'articles.popular.week';
    const POPULAR_MONTH_STORAGE_NAME = 'articles.popular.month';
    const POPULAR_ALLTIME_STORAGE_NAME = 'articles.popular.alltime';

    /**
     * @var ServiceProviderInterface
     */
    protected $serviceProvider;

    public function __construct(ServiceProviderInterface $serviceProvider)
    {
        parent::__construct();

        $this->serviceProvider = $serviceProvider;
    }

    /**
     * @return StorageInterface
     */
    protected function storage()
    {
        return $this->serviceProvider->getStorage();
    }

    /**
     * @return EntityManagerInterface
     */
    protected function entityManager()
    {
        return $this->serviceProvider->getEntityManager();
    }

    /**
     * @param  string $article
     */
    public function articleHasBeenShown($article)
    {
        $articleView = new ArticleView();
        $articleView->setArticle($article);
        $articleView->setDate(new \DateTime());
        $articleView = serialize($articleView);
        $this->storage()->append(self::SHOWSTATS_STORAGE_NAME, $articleView . PHP_EOL);
    }

    public function flushToDatabase()
    {
        if ($this->storage()->exists(self::SHOWSTATS_STORAGE_NAME)) {
            $stats = $this->storage()->read(self::SHOWSTATS_STORAGE_NAME);
            $this->storage()->delete(self::SHOWSTATS_STORAGE_NAME);
            $list = explode(PHP_EOL, $stats);
            foreach($list as $serialized) {
                if ( ! empty($serialized)) {
                    $entity = unserialize($serialized);
                    $this->entityManager()->persist($entity);
                }
            }
            $this->entityManager()->flush();
        }
    }

    protected function preparePopular(\DateTime $periodStart, \DateTime $periodEnd)
    {
        $dql = "SELECT v.article article, COUNT(v) times
                FROM App:ArticleView v
                WHERE
                    v.date >= :start
                    AND
                    v.date <= :end
                GROUP BY article
                ORDER BY times DESC";
        return $this->entityManager()
                    ->createQuery($dql)
                    ->setParameter('start', $periodStart)
                    ->setParameter('end', $periodEnd)
                    ->setMaxResults(50)
                    ->getResult();
    }

    public function preparePopularToday()
    {
        $list = $this->preparePopular(new \DateTime('-1 day'), new \DateTime());
        $this->storage()->write(self::POPULAR_TODAY_STORAGE_NAME, serialize($list));
    }

    public function preparePopularThisWeek()
    {
        $list = $this->preparePopular(new \DateTime('-7 day'), new \DateTime());
        $this->storage()->write(self::POPULAR_WEEK_STORAGE_NAME, serialize($list));
    }

    public function preparePopularThisMonth()
    {
        $list = $this->preparePopular(new \DateTime('-1 month'), new \DateTime());
        $this->storage()->write(self::POPULAR_MONTH_STORAGE_NAME, serialize($list));
    }

    public function preparePopularAllTime()
    {
        $list = $this->preparePopular(\DateTime::createFromFormat('!', ''), new \DateTime());
        $this->storage()->write(self::POPULAR_ALLTIME_STORAGE_NAME, serialize($list));
    }

    public function getPopularToday()
    {
        if ($this->storage()->exists(self::POPULAR_TODAY_STORAGE_NAME)) {
            return unserialize($this->storage()->read(self::POPULAR_TODAY_STORAGE_NAME));
        } else {
            return array();
        }
    }

    public function getPopularThisWeek()
    {
        if ($this->storage()->exists(self::POPULAR_WEEK_STORAGE_NAME)) {
            return unserialize($this->storage()->read(self::POPULAR_WEEK_STORAGE_NAME));
        } else {
            return array();
        }
    }

    public function getPopularThisMonth()
    {
        if ($this->storage()->exists(self::POPULAR_MONTH_STORAGE_NAME)) {
            return unserialize($this->storage()->read(self::POPULAR_MONTH_STORAGE_NAME));
        } else {
            return array();
        }
    }

    public function getPopularAllTime()
    {
        if ($this->storage()->exists(self::POPULAR_ALLTIME_STORAGE_NAME)) {
            return unserialize($this->storage()->read(self::POPULAR_ALLTIME_STORAGE_NAME));
        } else {
            return array();
        }
    }
}
