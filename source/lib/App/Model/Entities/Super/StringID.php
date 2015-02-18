<?php
namespace App\Model\Entities\Super;

/**
 * @MappedSuperclass
 */
class StringID extends Entity
{
    /**
     * @Id
     * @Column(type="string")
     */
    private $id = null;

    /**
     * Set id
     *
     * @param string $id
     * @return StringID
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
}
