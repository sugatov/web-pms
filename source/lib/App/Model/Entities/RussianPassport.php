<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity
 */
class RussianPassport extends Document
{
    /**
     * @ORM\Column(type="string", name="RussianPassport_serial", length=4, unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $serial;

    /**
     * @ORM\Column(type="string", name="RussianPassport_number", length=6, unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $number;

    /**
     * @ORM\Column(type="string", name="RussianPassport_issuedBy", unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $issuedBy;

    /**
     * @ORM\Column(type="date", name="RussianPassport_issueDate", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime<Y-m-d>")
     */
    private $issueDate;


    /**
     * Set serial
     *
     * @param string $serial
     * @return RussianPassport
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get serial
     *
     * @return string
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return RussianPassport
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set issuedBy
     *
     * @param string $issuedBy
     * @return RussianPassport
     */
    public function setIssuedBy($issuedBy)
    {
        $this->issuedBy = $issuedBy;

        return $this;
    }

    /**
     * Get issuedBy
     *
     * @return string
     */
    public function getIssuedBy()
    {
        return $this->issuedBy;
    }

    /**
     * Set issueDate
     *
     * @param \DateTime $issueDate
     * @return RussianPassport
     */
    public function setIssueDate($issueDate)
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    /**
     * Get issueDate
     *
     * @return \DateTime
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }
}
