<?php
/**
 * @copyright Copyright (c) 2014 Carsten Brandt
 * @license https://github.com/cebe/markdown/blob/master/LICENSE
 * @link https://github.com/cebe/markdown#readme
 */

namespace cebe\markdown\inline\custom;

// Modified to force parsing of inline elements in URL's
trait LinkTrait
{
    /**
     * Parses a link indicated by `[`.
     * @marker [
     */
    protected function parseLink($markdown)
    {
        if (!in_array('parseLink', array_slice($this->context, 1)) && ($parts = $this->parseLinkOrImage($markdown)) !== false) {
            list($text, $url, $title, $offset, $key) = $parts;
            return [
                [
                    'link',
                    'text' => $this->parseInline($text),
                    'url' => $this->parseInline($url),
                    'title' => $title,
                    'refkey' => $key,
                    'orig' => substr($markdown, 0, $offset),
                ],
                $offset
            ];
        } else {
            // remove all starting [ markers to avoid next one to be parsed as link
            $result = '[';
            $i = 1;
            while (isset($markdown[$i]) && $markdown[$i] == '[') {
                $result .= '[';
                $i++;
            }
            return [['text', $result], $i];
        }
    }

    protected function renderLink($block)
    {
        if (isset($block['refkey'])) {
            if (($ref = $this->lookupReference($block['refkey'])) !== false) {
                $block = array_merge($block, $ref);
            } else {
                return $block['orig'];
            }
        }
        return '<a href="' . htmlspecialchars($this->renderAbsy($block['url']), ENT_COMPAT | ENT_HTML401, 'UTF-8') . '"'
            . (empty($block['title']) ? '' : ' title="' . htmlspecialchars($block['title'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8') . '"')
            . '>' . $this->renderAbsy($block['text']) . '</a>';
    }


    /**
     * Parses an image indicated by `![`.
     * @marker ![
     */
    protected function parseImage($markdown)
    {
        if (($parts = $this->parseLinkOrImage(substr($markdown, 1))) !== false) {
            list($text, $url, $title, $offset, $key) = $parts;

            return [
                [
                    'image',
                    'text' => $text,
                    'url' => $this->parseInline($url),
                    'title' => $title,
                    'refkey' => $key,
                    'orig' => substr($markdown, 0, $offset + 1),
                ],
                $offset + 1
            ];
        } else {
            // remove all starting [ markers to avoid next one to be parsed as link
            $result = '!';
            $i = 1;
            while (isset($markdown[$i]) && $markdown[$i] == '[') {
                $result .= '[';
                $i++;
            }
            return [['text', $result], $i];
        }
    }

    protected function renderImage($block)
    {
        if (isset($block['refkey'])) {
            if (($ref = $this->lookupReference($block['refkey'])) !== false) {
                $block = array_merge($block, $ref);
            } else {
                return $block['orig'];
            }
        }
        return '<img src="' . htmlspecialchars($this->renderAbsy($block['url']), ENT_COMPAT | ENT_HTML401, 'UTF-8') . '"'
            . ' alt="' . htmlspecialchars($block['text'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8') . '"'
            . (empty($block['title']) ? '' : ' title="' . htmlspecialchars($block['title'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8') . '"')
            . ($this->html5 ? '>' : ' />');
    }

    protected function parseLinkOrImage($markdown)
    {
        if (strpos($markdown, ']') !== false && preg_match('/\[((?>[^\]\[]+|(?R))*)\]/', $markdown, $textMatches)) { // TODO improve bracket regex
            $text = $textMatches[1];
            $offset = strlen($textMatches[0]);
            $markdown = substr($markdown, $offset);

            $pattern = <<<REGEXP
                /(?(R) # in case of recursion match parentheses
                     \(((?>[^\s()]+)|(?R))*\)
                |      # else match a link with title
                    ^\((((?>[^\s()]+)|(?R))*)(\s+"(.*?)")?\)
                )/x
REGEXP;
            if (preg_match($pattern, $markdown, $refMatches)) {
                // inline link
                return [
                    $text,
                    isset($refMatches[2]) ? $refMatches[2] : '', // url
                    empty($refMatches[5]) ? null: $refMatches[5], // title
                    $offset + strlen($refMatches[0]), // offset
                    null, // reference key
                ];
            } elseif (preg_match('/^([ \n]?\[(.*?)\])?/s', $markdown, $refMatches)) {
                // reference style link
                if (empty($refMatches[2])) {
                    $key = strtolower($text);
                } else {
                    $key = strtolower($refMatches[2]);
                }
                return [
                    $text,
                    null, // url
                    null, // title
                    $offset + strlen($refMatches[0]), // offset
                    $key,
                ];
            }
        }
        return false;
    }
}
