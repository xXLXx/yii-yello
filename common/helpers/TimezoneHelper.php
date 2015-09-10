<?php

namespace common\helpers;

/**
 * Helpers involving timezone.
 */
class TimezoneHelper
{
    /**
     * Converts date to UTC.
     *
     * @param string $timezone
     * @param \DateTime|string $date
     *
     * @return \DateTime converted date
     */
    public static function convertToUTC($timezone, $date)
    {
        if (!($date instanceof \DateTime)) {
            $date = new \DateTime($date);
        }

        if ($date->getTimezone()->getName() !== $timezone) {
            $date->setTimezone(new \DateTimeZone($timezone));
        }

        return $date->setTimezone(new \DateTimeZone('UTC'));
    }

    /**
     * Converts date from UTC to specified timezone.
     *
     * @param string $timezone
     * @param \DateTime|string $date
     *
     * @return \DateTime converted date
     */
    public static function convertFromUTC($timezone, $date)
    {
        if (!($date instanceof \DateTime)) {
            $date = new \DateTime($date);
        }

        if ($date->getTimezone()->getName() !== 'UTC') {
            $date->setTimezone(new \DateTimeZone('UTC'));
        }

        return $date->setTimezone(new \DateTimeZone($timezone));
    }

    /**
     * Converts date from timezone to GMT.
     *
     * @param string $timezone
     * @param string $timestamp
     *
     * @return string converted date in 'Y-m-d H:i:s'
     */

    public static function convertToGMT($timezone, $timeStamp)
    {
        $timeOffset = timezone_offset_get(new \DateTimeZone($timezone),new \DateTime());

        $gmtTimeStamp = (int)$timeStamp - $timeOffset;
        return date('Y-m-d H:i:s', $gmtTimeStamp);

    }

    /**
     * Converts datetime from GMT to timezone.
     *
     * @param string $timezone
     * @param string $dateTime - MySql datetime format Y-m-d H:i:s
     *
     * @return string converted date in 'Y-m-d H:i:s'
     */

    public static function convertGMTToTimeZone($timezone, $dateTime)
    {
        $timeStamp = strtotime($dateTime);
        $timeOffset = timezone_offset_get(new \DateTimeZone($timezone),new \DateTime());

        $zoneTimeStamp = (int)$timeStamp + ($timeOffset );
        return date('Y-m-d H:i:s', $zoneTimeStamp);
    }
}
