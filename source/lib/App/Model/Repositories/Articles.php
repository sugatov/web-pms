<?php
namespace App\Model\Repositories;

use \Doctrine\ORM\EntityRepository;
use \App\Model\Entities\Article;
use \App\Model\Entities\Event;
use \App\Model\Entities\Location;

class Articles extends EntityRepository
{
    /**
     * @param  string $name
     * @return Article|null
     */
    public function getLatestVersion($name)
    {
        return $this->createQueryBuilder('a')
                    ->where('a.name = :name')
                    ->orderBy('a.id', 'DESC')
                    ->setParameter('name', $name)
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    /**
     * @param  string $name
     * @return \Doctrine\ORM\Query
     */
    public function getVersionsQuery($name)
    {
        return $this->createQueryBuilder('a')
                    ->where('a.name = :name')
                    ->orderBy('a.id', 'DESC')
                    ->setParameter('name', $name)
                    ->getQuery();
    }

    /**
     * @param  string $name
     * @return Article|array
     */
    public function getVersions($name)
    {
        return $this->getVersionsQuery($name)
                    ->getResult();
    }

    /**
     * Create a QueryBuilder for Events
     * @param  string $alias
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createEventsQueryBuilder($alias)
    {
        return $this->createQueryBuilder($alias)
                    ->where($alias . ' INSTANCE OF App:Event');
    }

    /**
     * Create a QueryBuilder for Locations
     * @param  string $alias
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createLocationsQueryBuilder($alias)
    {
        return $this->createQueryBuilder($alias)
                    ->where($alias . ' INSTANCE OF App:Location');
    }

    /**
     * Create Article list query
     * @param  string $alias
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createListQuery($alias)
    {
        return $this->createQueryBuilder($alias)
                    ->groupBy($alias . '.name')
                    ->getQuery();
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function getLatestUpdatesQuery()
    {
        $dql = "SELECT art FROM App:Article art
                WHERE art.id IN
                    (SELECT MAX(sub.id) FROM App:Article sub GROUP BY sub.name)
                ORDER BY art.id DESC";
        return $this->getEntityManager()->createQuery($dql);
    }

    /**
     * Create a QueryBuilder which contains nonrecurring Articles
     * @param  string $alias
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createNonrecurringQueryBuilder($alias)
    {
        return $this->createQueryBuilder($alias)
                    ->groupBy($alias . '.name');
    }

    /**
     * @param  integer $year
     * @param  integer $month
     * @param  integer $day
     * @return \Doctrine\ORM\Query
     */
    public function getEventsByDateQuery($year, $month = null, $day = null)
    {
        $queryBuilder = $this->getEntityManager()
                             ->getRepository('App:Event')
                             ->createQueryBuilder('e');
        $queryBuilder->where('YEAR(e.eventDate) = :year')
                     ->setParameter('year', intval($year));
        if ($month) {
            $queryBuilder->andWhere('MONTH(e.eventDate) = :month')
                         ->setParameter('month', intval($month));
        }
        if ($day) {
            $queryBuilder->andWhere('DAY(e.eventDate) = :day')
                         ->setParameter('day', intval($day));
        }
        return $queryBuilder->groupBy('e.name')->getQuery();
    }

    /**
     * @param  integer $century
     * @return \Doctrine\ORM\Query
     */
    public function getEventsByCenturyQuery($century)
    {
        $dql = "SELECT e
                FROM App:Event e
                WHERE
                    SUBSTRING(YEAR(e.eventDate), 1, 2) = :century
                GROUP BY e.name";
        return $this->getEntityManager()
                    ->createQuery($dql)
                    ->setParameter('century', intval($century)-1);
    }

    /**
     * @param  integer $century
     * @param  integer $decade
     * @return \Doctrine\ORM\Query
     */
    public function getEventsByDecadeQuery($century, $decade)
    {
        $dql = "SELECT e
                FROM App:Event e
                WHERE
                    SUBSTRING(YEAR(e.eventDate), 1, 3) = CONCAT(:century, :decade)
                GROUP BY e.name";
        return $this->getEntityManager()
                    ->createQuery($dql)
                    ->setParameter('century', intval($century)-1)
                    ->setParameter('decade', intval($decade)-1);
    }


    // TODO: Get this by 1 query if that's possible
    /**
     * @return array
     */
    public function getEventCenturyList()
    {
        $dql = "SELECT SUBSTRING(YEAR(e.eventDate), 1, 2) century, COUNT(e) length
                FROM App:Event e
                GROUP BY century";
        $list = $this->getEntityManager()->createQuery($dql)->getResult();
        foreach ($list as &$item) {
            $item['century'] += 1;
            unset($item);
        }
        return $list;
    }

    /**
     * @param integer $century
     * @return array
     */
    public function getEventDecadeList($century)
    {
        $century = intval($century) - 1;
        $dql = "SELECT SUBSTRING(YEAR(e.eventDate), 1, 2) century, SUBSTRING(YEAR(e.eventDate), 3, 1) decade, COUNT(e) length
                FROM App:Event e
                WHERE SUBSTRING(YEAR(e.eventDate), 1, 2) = :century
                GROUP BY century, decade";
        $list = $this->getEntityManager()
                     ->createQuery($dql)
                     ->setParameter('century', $century)
                     ->getResult();
        foreach ($list as &$item) {
            $item['century'] += 1;
            $item['decade'] += 1;
            unset($item);
        }
        return $list;
    }

    /**
     * @param integer $century
     * @param integer $decade
     * @return array
     */
    public function getEventYearList($century, $decade)
    {
        $century = intval($century) - 1;
        $decade = $century . (intval($decade) - 1);
        $dql = "SELECT YEAR(e.eventDate) year, COUNT(e) length
                FROM App:Event e
                WHERE SUBSTRING(YEAR(e.eventDate), 1, 3) = :decade
                GROUP BY year";
        return $this->getEntityManager()
                    ->createQuery($dql)
                    ->setParameter('decade', $decade)
                    ->getResult();
    }

    /**
     * @param  integer $year
     * @return array
     */
    public function getEventMonthList($year)
    {
        $dql = "SELECT MONTH(e.eventDate) month, COUNT(e) length
                FROM App:Event e
                WHERE YEAR(e.eventDate) = :year
                GROUP BY month";
        return $this->getEntityManager()
                    ->createQuery($dql)
                    ->setParameter('year', intval($year))
                    ->getResult();
    }
}
