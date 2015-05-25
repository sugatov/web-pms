<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class Room extends Super\IntegerID
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("boolean")
     */
    protected $isAvailable;


    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\DTO\RoomCategory")
     */
    protected $roomCategory;
    public function getRoomCategory()
    {
        $val = $this->entity->getRoomCategory();
        if ($val !== null) {
            $val = new RoomCategory($val, $this->entityManager, $this->annotationReader);
        }
        // $val = new RoomCategory($val, $this->entityManager);
        return $val;
    }
    public function setRoomCategory($val)
    {
        if ($val instanceof RoomCategory) {
            $this->entityManager->detach($val->getEntity());
            $this->entity->setRoomCategory($this->entityManager->getReference('App:RoomCategory', $val->getId()));
        }
    }
}
