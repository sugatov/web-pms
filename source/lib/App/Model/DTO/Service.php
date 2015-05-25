<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class Service extends Super\IntegerID
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\DTO\Invoice")
     */
    protected $invoice;
    public function getInvoice()
    {
        $val = $this->entity->getInvoice();
        if ($val !== null) {
            $val = new Invoice($val, $this->entityManager);
        }
        return $val;
    }
    public function setInvoice($val)
    {
        if ($val instanceof Invoice) {
            $this->entityManager->detach($val->getEntity());
            $this->entity->setInvoice($this->entityManager->getReference('App:Invoice', $val->getId()));
        }
    }

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
     * @Serializer\Type("string")
     */
    protected $comment;

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
