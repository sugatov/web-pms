<?php
namespace Entities;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="User")
 */
class User extends \Hotel\Entity {
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id = null;
    
}
