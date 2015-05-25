<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class Invoice extends Super\IntegerID
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\DTO\Check")
     */
    protected $check;
    public function getCheck()
    {
        $val = $this->entity->getCheck();
        if ($val !== null) {
            $val = new Check($val, $this->entityManager);
        }
        return $val;
    }
    public function setCheck($val)
    {
        if ($val instanceof Check) {
            $this->entityManager->detach($val->getEntity());
            $this->entity->setCheck($this->entityManager->getReference('App:Check', $val->getId()));
        }
    }

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("boolean")
     */
    protected $isClosed;


    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\DTO\Payment")
     */
    protected $payment;
    public function getPayment()
    {
        $val = $this->entity->getPayment();
        if ($val !== null) {
            $val = new Payment($val, $this->entityManager);
        }
        return $val;
    }
    public function setPayment($val)
    {
        if ($val instanceof Payment) {
            $this->entityManager->detach($val->getEntity());
            $this->entity->setPayment($this->entityManager->getReference('App:Payment', $val->getId()));
        }
    }
}
