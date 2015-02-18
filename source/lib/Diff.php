<?php
use \TextCompareInterface;
use SebastianBergmann\Diff\Differ;

class Diff implements TextCompareInterface
{
    /**
     * Compare plain text
     * @param  string $original
     * @param  string $new
     * @param  string $originalName
     * @param  string $newName
     * @return string
     */
    public function compare($original, $new, $originalName=null, $newName=null)
    {
        if (empty($originalName)) {
            $originalName = 'Оригинал';
        }
        if (empty($newName)) {
            $newName = 'Новый';
        }
        $differ = new Differ($header = "--- $originalName\n+++ $newName\n");
        return $differ->diff($original, $new);
    }
}
