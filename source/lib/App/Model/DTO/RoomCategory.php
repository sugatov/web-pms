<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class RoomCategory extends Super\IntegerID
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("double")
     */
    protected $price;
    public function getPrice()
    {
        return $this->entity->getPrice() / 100;
    }
    public function setPrice($val)
    {
        $this->entity->setPrice(intval($val * 100));
    }

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $designation;

}
