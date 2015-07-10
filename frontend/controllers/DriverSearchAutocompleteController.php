<?php

namespace frontend\controllers;

use common\models\Driver;
use yii\web\NotFoundHttpException;
use common\models\search\DriverSearch;

/**
 * Driver search controller
 *
 * @author markov
 */
class DriverSearchAutocompleteController extends BaseController 
{
    /**
     * Autocomplete
     */
    public function actionAutocomplete()
    {
        $params = \Yii::$app->request->post();
        if (isset($params['driverGroup'])) {
            static $assoc = [
                'isMyDrivers'    => 'my', 
                'isFavourites'   => 'favourites'
            ];
            $params['category'] = $assoc[$params['driverGroup']];
        }
        $driverSearch = new DriverSearch();
        $drivers = $driverSearch->buildQuery($params)->all();
        if (!$drivers) {
            return false;
        }
        return $this->renderPartial('autocomplete', [
            'drivers' => $drivers
        ]);
    }
    
    /**
     * Get selected driver results
     * 
     * @throws NotFoundHttpException
     */
    public function actionSelected()
    {
        $driverId = \Yii::$app->request->post('driverId');
        $driver = Driver::findOne($driverId);
        if (!$driver) {
            throw new NotFoundHttpException('the driver cannot be found.');
        }
        return $this->renderPartial('selected', [
            'driver' => $driver
        ]); 
    }
}
