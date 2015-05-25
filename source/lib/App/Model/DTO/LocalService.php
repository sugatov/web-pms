<?php
namespace App\Model\DTO;

use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

class LocalService extends Service
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\DTO\LocalServiceType")
     */
    protected $type;
    public function getType()
    {
        $val = $this->entity->getType();
        if ($val !== null) {
            $val = new LocalServiceType($val, $this->entityManager);
        }
        return $val;
    }
    public function setType($val)
    {
        if ($val instanceof LocalServiceType) {
            $this->entityManager->detach($val->getEntity());
            $this->entity->setType($this->entityManager->getReference('App:LocalServiceType', $val->getId()));
        }
    }

}
