<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Exceptions\ValidationException;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity
 */
class Customer extends User
{
    /**
     * @ORM\Column(type="string", name="Customer_email", unique=true, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity="Account", mappedBy="customer")
     * @Serializer\Expose(true)
     * @Serializer\Type("App\Model\Entities\Account")
     */
    private $account;

    /**
     * @ORM\OneToMany(targetEntity="Check", mappedBy="customer")
     */
    private $checks;

    /**
     * @ORM\Column(type="text", name="Customer_comment", nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $comment = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->checks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Customer
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set account
     *
     * @param \App\Model\Entities\Account $account
     * @return Customer
     */
    public function setAccount(\App\Model\Entities\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \App\Model\Entities\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Add checks
     *
     * @param \App\Model\Entities\Check $checks
     * @return Customer
     */
    public function addCheck(\App\Model\Entities\Check $checks)
    {
        $this->checks[] = $checks;

        return $this;
    }

    /**
     * Remove checks
     *
     * @param \App\Model\Entities\Check $checks
     */
    public function removeCheck(\App\Model\Entities\Check $checks)
    {
        $this->checks->removeElement($checks);
    }

    /**
     * Get checks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChecks()
    {
        return $this->checks;
    }
}
