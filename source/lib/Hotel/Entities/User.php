<?php
namespace Hotel\Entities;

use \Doctrine\Common\Collections\ArrayCollection;
use \Entity;

/**
 * @Entity
 * @Table(name="User")
 */
class User extends Entity {
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id = null;
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
