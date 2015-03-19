<?php
namespace App\Model\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use App\Model\Entities\Upload;
use App\Model\Entities\UploadImage;

class Uploads extends EntityRepository
{
    /**
     * @param  string $alias
     * @return QueryBuilder
     */
    public function createImageQueryBuilder($alias)
    {
        return $this->createQueryBuilder($alias)
                    ->where($alias . ' INSTANCE OF App:UploadImage');
    }
}
