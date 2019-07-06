<?php

namespace frontend\widgets\StoreInviteDriverSelected;

use common\models\Driver;

/**
 * Store invite driver selected widget
 *
 * @author markov
 */
class StoreInviteDriverSelectedWidget extends \yii\base\Widget
{
    /**
     * Driver
     *
     * @var integer 
     */
    public $driverId; 
    
    /**
     * @inheritdoc
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