<?php
class DateTime_Ymd extends DateTime
{
    public function __toString()
    {
        return $this->format('Y-m-d');
    }
}
