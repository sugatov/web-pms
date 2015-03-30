<?php
namespace App\Model\Entities;

use App\Model\Exceptions\ValidationException;

/**
 * @Entity(repositoryClass="\App\Model\Repositories\Users")
 */
class User extends Super\StringID
{
    /**
     * Set id
     * @param string $id
     * @return User
     */
    public function setId($id)
    {
        if (empty($id)) {
            throw new ValidationException('Имя пользователя не может быть пустым!');
        }

        return parent::setId($id);
    }
}
