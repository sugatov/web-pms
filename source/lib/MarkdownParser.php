<?php
class MarkdownParser extends ParsedownExtra
{
    public function __construct()
    {
        parent::__construct();
        $this->setMarkupEscaped(true);
    }

    public function parse($source)
    {
        return $this->text($source);
    }
}
