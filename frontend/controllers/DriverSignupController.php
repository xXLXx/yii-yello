<?php

namespace frontend\controllers;

use api\common\models\WorkDetailsForm;
use common\models\Driver;
use frontend\models\UserForm\DriverForm;
use frontend\models\VehicleForm;
use yii\helpers\Json;
use common\models\Company;
use common\models\CompanyAddress;
use common\models\Address;

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

        if(isset($post['DriverSignupStep1'])){
            $post['DriverForm'] = $post['DriverSignupStep1'];
            $post['DriverForm']['firstName'] = $user->firstName;
            $post['DriverForm']['lastName'] = $user->lastName;
        }
        $model = new DriverForm();
        if ($model->load($post)) {
            if ($model->validate()) {
                $model->save();

                $companyobj = Company::findOne(['userfk'=>$user->id, 'isPrimary'=>1]);

                $companyaddress = CompanyAddress::findOne(['companyfk'=>$companyobj->id , 'addresstitle'=>'Default']);

                $address= Address::findOne(['idaddress'=>$companyaddress->idcompanyaddress]);

                if(!$address){
                    $address = new Address();
                }

                $address->save();
                $companyaddress->addressfk = $address->idaddress;
                $companyaddress->save();

                $post['Address'] = $post['DriverSignupStep1'];

                $address->load($post);
                $address->setAttributes($address->getattributes());
                $address->save();

                $this->refresh();
            } else {
                return $this->render('index', [
                    'model'     => $driversignupform,
                    'errors'    => $model->getErrors()
                ]);
            }
        }

        //return $model;


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

        if(isset($post['DriverSignupStep2'])){
            $post['VehicleForm'] = $post['DriverSignupStep2'];
        }
        $model = new VehicleForm();
        if ($model->load($post)) {

           if ($model->validate()) {
                $model->save();
                $this->refresh();
            } else {
               return $this->render('step2_vehicleinfo', [
                   'model'     => $driversignupform,
                   'errors'    => $model->getErrors()
               ]);
            }

        }
        //return $model;

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


        if(isset($post['DriverSignupStep3'])){
            $post['WorkDetailsForm'] = $post['DriverSignupStep3'];
            $model = new WorkDetailsForm();
            if ($model->load($post)) {
                if ($model->validate()) {
                    $model->save();
                    $this->redirect('/driver/index');
                } else {
                    return $this->render('step3_workinfo', [
                        'model'     => $driversignupform,
                        'errors'    => $model->getErrors()
                    ]);
                }
            }
        }

        return $this->render('step3_workinfo', [
            'model' => $driversignupform
        ]);

    }



}