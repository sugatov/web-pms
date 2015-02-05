<?php
use cebe\markdown\MarkdownExtra;
use Doctrine\ORM\EntityRepository;

class MarkdownParser extends MarkdownExtra
{
    use cebe\markdown\inline\custom\LinkTrait;

    protected $articles, $uploads;

    public function __construct(EntityRepository $articles = null, EntityRepository $uploads = null)
    {
        $this->articles  = $articles;
        $this->uploads   = $uploads;
        $this->html5     = true;
    }


    /**
     * @marker %#
     */
    protected function parseArticle($markdown)
    {
        if (preg_match('/^%#(.+)%/', $markdown, $matches)) {
            return [
                [
                    'article',
                    'id' => $matches[1]
                ],
                strlen($matches[0])
            ];
        }
        return [['text', '%#'], 2];
    }

    // only URL
    protected function renderArticle($element)
    {
        return '/#' . $element['id'];
    }


    /**
     * @marker %^
     */
    protected function parseUpload($markdown)
    {
        if (preg_match('/^%\^(.+)%/', $markdown, $matches)) {
            return [
                [
                    'upload',
                    'id' => $matches[1]
                ],
                strlen($matches[0])
            ];
        }
        return [['text', '%^'], 2];
    }

    // only URL
    protected function renderUpload($element)
    {
        return '/uploads/' . $element['id'];
    }
}
