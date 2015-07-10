<?php

namespace frontend\controllers;
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
                return 'success';
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
