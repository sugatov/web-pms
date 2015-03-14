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
}
