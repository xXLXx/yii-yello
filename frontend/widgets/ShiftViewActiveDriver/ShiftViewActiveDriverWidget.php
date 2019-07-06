<?php

namespace frontend\widgets\ShiftViewActiveDriver;

use common\models\Driver;

/**
 * Shift view active driver widget
 *
 * @author markov
 */
class ShiftViewActiveDriverWidget extends \yii\base\Widget
{
    /**
     * Driver
     *
     * @var integer 
     */
    public $driverId; 
    
    /**
     * 
     */
    public function run()
    {
        $driver = Driver::findOne($this->driverId);
        if (!$driver) {
            return null;
        }
        return $this->render('default', [
            'driver' => $driver
        ]);
    }
}
