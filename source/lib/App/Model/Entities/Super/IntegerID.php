<?php
namespace App\Model\Entities\Super;

/**
 * @MappedSuperclass
 */
class IntegerID extends Entity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id = null;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ID. A hack for serializer
     * @param integer $id identifier
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
