<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class Customer extends User
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $email;

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
     * @Serializer\Type("string")
     */
    protected $comment;

}
