<?php

namespace frontend\widgets\DriverDetails;

use \yii\base\Widget;
use \common\models\Driver;

/**
 * Class DriverDetailsWidget
 * @package frontend\widgets\DriverDetails
 *
 * @author Yarovikov
 */
class DriverDetailsWidget extends Widget
{

    public $driver;

    public function run()
    {
        if ( $this->driver instanceof Driver ) {

            return $this->render('driverDetails', [
                'driver' => $this->driver,
            ]);
        }

        return '';
    }

}