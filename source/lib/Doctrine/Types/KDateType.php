<?php
namespace Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;
use DateTime_Ymd;


class KDateType extends DateType
{
    const NAME = 'kdate';

    public function getName()
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $date = parent::convertToPHPValue($value, $platform);
        if ( ! $date) {
            return $date;
        }
        $format = $platform->getDateFormatString();
        $val = new DateTime_Ymd($date->format($format));
        if ( ! $val) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $format);
        }
        return $val;
    }
}
