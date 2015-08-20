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
}
