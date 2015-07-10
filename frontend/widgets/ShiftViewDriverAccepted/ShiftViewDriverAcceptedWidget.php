<?php

namespace frontend\widgets\ShiftViewDriverAccepted;

/**
 * Shift view driver assigned
 *
 * @author markov
 */
class ShiftViewDriverAcceptedWidget extends \yii\base\Widget
{
    /**
     * Shift
     *
     * @var \common\models\Shift
     */
    public $shift;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $driver = $this->shift->driverAccepted;
        if (!$driver) {
            return null;
        }
        return $this->render('default', [
            'driver' => $driver,
            'shift'  => $this->shift
        ]);
    }
}

