<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class Document extends Super\IntegerID
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $data;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\DTO\Customer")
     */
    protected $customer;
    public function getCustomer()
    {
        $val = $this->entity->getCustomer();
        if ($val !== null) {
            $val = new Customer($val, $this->entityManager);
        }
        return $val;
    }
    public function setCustomer($val)
    {
        if ($val instanceof Customer) {
            $this->entityManager->detach($val->getEntity());
            $this->entity->setCustomer($this->entityManager->getReference('App:Customer', $val->getId()));
        }
    }
}
