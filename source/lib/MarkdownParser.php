<?php
use App\Services\Uploads;

class MarkdownParser extends ParsedownExtra
{
    protected $_url;
    protected $_uploads;
    protected $_PUBLIC_UPLOADS;

    /**
     * @param URLInterface $url
     * @param Uploads      $uploads
     * @parem string       $PUBLIC_UPLOADS
     */
    public function __construct(URLInterface $url, Uploads $uploads, $PUBLIC_UPLOADS)
    {
        $this->_url            = $url;
        $this->_uploads        = $uploads;
        $this->_PUBLIC_UPLOADS = $PUBLIC_UPLOADS;
        parent::__construct();
        $this->setMarkupEscaped(true);
    }

    public function parse($source)
    {
        return $this->text($source);
    }

    protected function inlineLink($Excerpt)
    {
        $element = array('name' => 'a',
                         'handler' => 'line',
                         'text' => null,
                         'attributes' => array('href' => null,
                                               'title' => null));
        $extent = 0;
        $text = $Excerpt['text'];
        $regexp = <<<REGEXP
        /\[((?:[^][]|(?R))*)\]/
REGEXP;
        if (preg_match($regexp, $text, $matches)) {
            $element['text'] = $matches[1];
            $extent += strlen($matches[0]);
            $text = substr($text, $extent);
            $regexp = <<<REGEXP
            /\(=[fFфФ]([\d]+)([\h]+"([\d\w\h]*)")?\)/u
REGEXP;
            if (preg_match($regexp, $text, $matches)) {
                $upload = $this->_uploads->find($matches[1]);
                $title  = '404';
                $url    = $this->_PUBLIC_UPLOADS . '/404notfound.png';
                if ($upload) {
                    $title = (isset($matches[3])) ? $matches[3] : null;
                    $url   = $this->_PUBLIC_UPLOADS . '/' . $upload->getFilename();
                }
                $element['attributes']['href']  = $url;
                $element['attributes']['title'] = $title;
                $extent += strlen($matches[0]);
                return array('extent' => $extent,
                             'element' => $element);
            } else {
                $regexp = <<<REGEXP
                /\(=([\d\w\h\.,]+)([\h]+"([\d\w\h]*)")?\)/u
REGEXP;
                if (preg_match($regexp, $text, $matches)) {
                    $url = $this->_url->getUrl('articles-show', array('name'=>$matches[1]));
                    $title = (isset($matches[3])) ? $matches[3] : null;
                    $element['attributes']['href']  = $url;
                    $element['attributes']['title'] = $title;
                    $extent += strlen($matches[0]);
                    return array('extent' => $extent,
                                 'element' => $element);
                }
            }
        }
        return parent::inlineLink($Excerpt);
    }
}
