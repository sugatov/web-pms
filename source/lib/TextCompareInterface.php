<?php
interface TextCompareInterface
{
    /**
     * Compare plain text
     * @param  string $original
     * @param  string $new
     * @param  string $originalName
     * @param  string $newName
     * @return string
     */
    public function compare($original, $new, $originalName=null, $newName=null);
}
