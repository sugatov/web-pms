<?php
namespace App\Model\Entities;

use \App\Model\Exceptions\ValidationException;

/**
 * @Entity(repositoryClass="\App\Model\Repositories\Users")
 */
class User extends Super\StringID
{
    /**
     * @OneToMany(targetEntity="Article", mappedBy="user")
     */
    private $articles;

    /**
     * Set id
     * @param string $id
     * @return User
     */
    public function setId($id)
    {
        if (empty($id)) {
            throw new ValidationException('Имя пользователя не может быть пустым!');
        }

        return parent::setId($id);
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add articles
     *
     * @param \App\Model\Entities\Article $articles
     * @return User
     */
    public function addArticle(\App\Model\Entities\Article $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \App\Model\Entities\Article $articles
     */
    public function removeArticle(\App\Model\Entities\Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
