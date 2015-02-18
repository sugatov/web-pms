<?php
namespace App\Model\Entities;

use \App\Model\Exceptions\ValidationException;

/**
 * @Entity(repositoryClass="\App\Model\Repositories\Articles")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string", length=16)
 * @DiscriminatorMap({"Article" = "Article", "Location" = "Location", "Event" = "Event"})
 */
class Article extends Super\IntegerID
{
    /**
     * @Column(type="string", unique=false, nullable=false)
     */
    private $name;
    
    /**
     * @Column(type="text", unique=false, nullable=false)
     */
    private $content;

    /**
     * @Column(type="datetime", nullable=false)
     */
    private $date;
       
    /**
     * @ManyToOne(targetEntity="Article")
     * @JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $basedOn;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $user;


    public function __construct()
    {
        $this->setDate(new \DateTime());
    }
    

    /**
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set basedOn
     *
     * @param \App\Model\Entities\Article $basedOn
     * @return Article
     */
    public function setBasedOn(\App\Model\Entities\Article $basedOn = null)
    {
        $this->basedOn = $basedOn;

        return $this;
    }

    /**
     * Get basedOn
     *
     * @return \App\Model\Entities\Article 
     */
    public function getBasedOn()
    {
        return $this->basedOn;
    }

    /**
     * Set user
     *
     * @param \App\Model\Entities\User $user
     * @return Article
     */
    public function setUser(\App\Model\Entities\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Model\Entities\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set name
     *
     * @param string $name
     * @throws ValidationException
     * @return Article
     */
    public function setName($name)
    {
        if (empty($name)) {
            throw new ValidationException('Имя статьи не может быть пустым!');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
