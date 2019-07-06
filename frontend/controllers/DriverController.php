<?php

namespace frontend\controllers;

use common\helpers\ArrayHelper;
use common\models\Driver;
use common\models\search\DriverSearch;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * Driver controller
 *
 * @author alex
 */
class DriverController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex(){
        $this->layout='simple';
        return $this->render('index');
    }

    /**
     * Form for invitation driver to the store
     */
    public function actionInviteForm()
    {
        return $this->render('inviteForm');
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