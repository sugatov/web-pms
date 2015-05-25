<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class LocalServiceType extends Super\IntegerID
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
     * @Serializer\Type("DateTime")
     */
    protected $created;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    protected $updated;

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
}
