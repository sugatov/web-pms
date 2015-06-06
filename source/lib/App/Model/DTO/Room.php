<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class Room extends Super\IntegerID
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    public $name;
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("boolean")
     */
    public $isAvailable;
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\DTO\RoomCategory")
     */
    public $roomCategory;

    /**
     * @Serializer\Expose(false)
     * @Serializer\Type("boolean")
     */
    public $roomCategory__;

    public function __construct($entityManager, $id)
    {
        parent::__construct($entityManager, $id);

        if ($this->entity) {
            $this->name = $this->entity->getName();
            $this->isAvailable = $this->entity->getIsAvailable();
            if ($this->entity->getRoomCategory()) {
                $this->roomCategory = new RoomCategory($entityManager, $this->entity->getRoomCategory()->getId());
            }
        }
    }




    /*
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\DTO\RoomCategory")
     */
    /*protected $roomCategory;
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
    }*/
}
