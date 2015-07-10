<?php

namespace frontend\widgets\DriverSearchAutocompleteSelected;

use common\models\Driver;

/**
 * DriverSearch autocomplete selected widget
 *
 * @author markov
 */
class DriverSearchAutocompleteSelectedWidget extends \yii\base\Widget
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