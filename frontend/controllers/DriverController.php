<?php

namespace frontend\controllers;

use common\models\Driver;
use common\models\search\DriverSearch;
use yii\helpers\Json;

/**
 * Driver controller
 *
 * @author alex
 */
class DriverController extends BaseController
{
    public function actionIndex(){
        $this->layout='simple';
        return $this->render('index');
    }




    /**
     * Form for invitation driver to the store
     */
    public function actionInviteForm()
    {
        return $this->renderPartial('inviteForm');
    }

    public function actionInviteSearch()
    {
        $post = \Yii::$app->request->post();
        $driverInput = $post['driver'];
        if (substr($driverInput, 0, 1) == '#') {
            $driverInput = substr($driverInput, 1);
        }
        if (is_numeric($driverInput)) {
            $driver = Driver::findOne($driverInput);
        } else {
            $driver = Driver::findOne([
                'like',
                'username',
                $driverInput
            ]);
        }
        $this->renderPartial('inviteSearch', [
            'driver' => $driver
        ]);
    }
}