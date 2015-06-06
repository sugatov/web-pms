<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class RoomCategory extends Super\IntegerID
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    public $name;
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("double")
     */
    public $price;
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    public $designation;

    public function __construct($entityManager, $id)
    {
        parent::__construct($entityManager, $id);

        if ($this->entity) {
            $this->name = $this->entity->getName();
            $this->price = $this->entity->getPrice() / 100;
            $this->designation = $this->entity->getDesignation();
        }
    }


    /*public function getPrice()
    {
        return $this->entity->getPrice() / 100;
    }
    public function setPrice($val)
    {
        $this->entity->setPrice(intval($val * 100));
    }*/


}
