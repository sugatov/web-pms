<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class Book extends Service
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime<Y-m-d>")
     */
    protected $firstDay;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime<Y-m-d>")
     */
    protected $lastDay;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("boolean")
     */
    protected $isConfirmed;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\DTO\Room")
     */
    protected $room;
    public function getRoom()
    {
        $val = $this->entity->getRoom();
        if ($val !== null) {
            $val = new Room($val, $this->entityManager);
        }
        return $val;
    }
    public function setRoom($val)
    {
        if ($val instanceof Room) {
            $this->entityManager->detach($val->getEntity());
            $this->entity->setRoom($this->entityManager->getReference('App:Room', $val->getId()));
        }
    }

}
