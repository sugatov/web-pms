<?php
namespace Repositories;

class User extends \EntityRepository
{
    public function getMany()
    {
        return $this->createQueryBuilder('user');
    }
}
