<?php

namespace frontend\controllers;

use common\models\Driver;
use yii\helpers\Json;

/**
 * Driver list controller
 *
 * @author alex
 */
class DriverSignupController extends BaseController
{
    /**
     * Page one of driver signup
     * This should reflect phone app in its behaviour
     */
    public function actionIndex()
    {

        $this->layout='signup';
        $user = \Yii::$app->user->identity;
        $post = \Yii::$app->request->post();
        $driversignupform = new \frontend\models\DriverSignupStep1();
        
        
        return $this->render('index', [
            'model'     => $driversignupform
        ]);

    }

    
    public function actionVehicleInfo()
    {
        $this->layout='signup';
        $user = \Yii::$app->user->identity;
        $post = \Yii::$app->request->post();
        $driversignupform = new \frontend\models\DriverSignupStep2();
        
        
        return $this->render('step2_vehicleinfo', [
            'model'     => $driversignupform
        ]);

    }
    
    
    public function actionWorkInfo()
    {

        $this->layout='signup';
        $user = \Yii::$app->user->identity;
        $post = \Yii::$app->request->post();
        $driversignupform = new \frontend\models\DriverSignupStep3();
        
        
        return $this->render('step3_workinfo', [
            'model'     => $driversignupform
        ]);

    }
    
        
    
}