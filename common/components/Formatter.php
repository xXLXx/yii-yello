<?php

namespace common\components;

/**
 * Formatter
 *
 * @author markov
 */
class Formatter extends \yii\i18n\Formatter  
{
    public function asDatetimeSpecial(\DateTime $dt)
    {
        return $this->asDatetime($dt) . " " . $this->timeZone;
    }
}
