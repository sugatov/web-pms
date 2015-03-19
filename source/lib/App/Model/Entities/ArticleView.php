<?php
namespace App\Model\Entities;

/**
 * @Entity
 * @Table(indexes={
 *     @Index(name="date_idx", columns={"date"}),
 *     @Index(name="article_idx", columns={"article"})
 * })
 */
class ArticleView extends Super\IntegerID
{
    /**
     * @Column(type="string", unique=false, nullable=false)
     */
    private $article = null;

    /**
     * @Column(type="datetime", nullable=false)
     */
    private $date = null;

    /**
     * Set article
     *
     * @param string $article
     * @return ArticleView
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ArticleView
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
}
