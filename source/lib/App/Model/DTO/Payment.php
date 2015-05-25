<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class Payment extends Super\IntegerID
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\DTO\Account")
     */
    protected $account;
    public function getAccount()
    {
        $val = $this->entity->getAccount();
        if ($val !== null) {
            $val = new Account($val, $this->entityManager);
        }
        return $val;
    }
    public function setAccount($val)
    {
        if ($val instanceof Account) {
            $this->entityManager->detach($val->getEntity());
            $this->entity->setAccount($this->entityManager->getReference('App:Account', $val->getId()));
        }
    }

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    protected $date;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("double")
     */
    protected $amount;
    public function getAmount()
    {
        return $this->entity->getAmount() / 100;
    }
    public function setAmount($val)
    {
        $this->entity->setAmount(intval($val * 100));
    }

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $currency;

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

}
