<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity
 */
class RussianPasport extends Document
{
    /**
     * @ORM\Column(type="string", name="RussianPasport_serial", length=4, unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $serial;
    
    /**
     * @ORM\Column(type="string", name="RussianPasport_number", length=6, unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $number;
    
    /**
     * @ORM\Column(type="string", name="RussianPasport_issuedBy", unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $issuedBy;
    
    /**
     * @ORM\Column(type="date", name="RussianPasport_issueDate", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("DateTime")
     */
    private $issueDate;
    

    /**
     * Set serial
     *
     * @param string $serial
     * @return RussianPasport
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
     * @return RussianPasport
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
     * @return RussianPasport
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
     * @return RussianPasport
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
