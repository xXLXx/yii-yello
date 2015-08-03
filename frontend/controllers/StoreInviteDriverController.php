<?php

namespace frontend\controllers;
use api\common\models\Driver;
use frontend\models\StoreInviteDriverForm;

/**
 * Store invite driver controller
 *
 * @author markov
 */
class StoreInviteDriverController extends BaseController
{
    /**
     * Send invite
     */
    public function actionIndex()
    {
        $this->layout = 'empty';
        $storeInviteDriverForm = new StoreInviteDriverForm();
        $params = \Yii::$app->request->post();
        if ($storeInviteDriverForm->load($params)) {
            if ($storeInviteDriverForm->validate()) {
                $storeInviteDriverForm->save();
                $driver_id = $params['StoreInviteDriverForm']['driverId'];
                $driver_data = Driver::findOne($driver_id);
                return $this->render('success', [
                    'driver_data' => $driver_data
                ]);
            }
        } else {
            $driverHasStoreId = \Yii::$app->request->post('id');
            $storeInviteDriverForm->setData($driverHasStoreId);
        }
        
        return $this->render('index', [
            'storeInviteDriverForm' => $storeInviteDriverForm
        ]);
    }
}
