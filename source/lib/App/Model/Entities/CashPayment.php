<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity
 */
class CashPayment extends Payment
{
}
