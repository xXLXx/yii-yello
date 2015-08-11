<?php

namespace frontend\controllers;

use api\common\models\WorkDetailsForm;
use common\models\Driver;
use common\models\Image;
use common\models\Vehicle;
use frontend\models\UserForm\DriverForm;
use frontend\models\VehicleForm;
use yii\helpers\Json;
use common\models\Company;
use common\models\CompanyAddress;
use common\models\Address;
use yii\web\UploadedFile;

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

        // process form submit
        if(isset($post['DriverSignupStep1'])){
            $post['DriverForm'] = $post['DriverSignupStep1'];
            if ($driversignupform->load($post)) {
                //if ($driversignupform->validate()) {
                    $driversignupform->saveStep1($user);
                    // add or replace the image
                    if(isset($_FILES['DriverSignupStep1']['name']['imageFile'])){
                        $user->imageId = $this->saveImage($driversignupform, 'imageFile');
                    }
                    // save address
                    $user->signup_step_completed = 1;
                    $user->save();
                    return \Yii::$app->getResponse()->redirect(['/driver-signup/vehicle-info']);
//                } else {
//                    return $this->render('index', [
//                        'model'     => $driversignupform,
//                        'errors'    => $driversignupform->getErrors()
//                    ]);
//                }
            }else{
                    return $this->render('index', [
                        'model'     => $driversignupform,
                        'errors'    => $driversignupform->getErrors()
                    ]);
            }
            
            
            
        }else{
            // TODO: check for existing data
            
            
        }

        //return $model;


        return $this->render('index', [
            'model'     => $driversignupform
        ]);

    }


    public function actionVehicleInfo()
    {
        // hi jovani, this not saving images  
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
                $model->save($user);// save is empty at the moment
                $vehicle = Vehicle::findOne(['driverId' => $user->id]);
               $vehicle->save();

               $user->signup_step_completed = 2;
               $user->save();
                $this->redirect(['driver-signup/work-info']);

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
        // hi jovani this is not saving data
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

                    $user->signup_step_completed = 3;
                    $user->save();

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

    public function saveImage($driversignupform, $image_name){

        $webPath = \Yii::$app->basePath . '/web';

        $imageDir = $webPath . '/upload/images/';
        if ( ! file_exists($imageDir) ) {
            FileHelper::createDirectory($imageDir);
        }

        $image_file = UploadedFile::getInstance($driversignupform, $image_name);
        //$img_path = $imageDir . $model->imageFile->baseName . '.' . $model->imageFile->extension;
        //$model->imageFile->saveAs( $img_path );

        $image = new Image();
        $image->imageFile = $image_file;
        if ($image->imageFile) {
            $image->save();
            $image->saveFiles();
            $image->save();
            return $image->id;
        }

    }

    public function saveAddress(){

        $user = \Yii::$app->user->identity;
        $post = \Yii::$app->request->post();
        $fullname = (string)  $user->firstName.' '.(string)$user->lastName;
        // make sure a company exists
        $companyobj = Company::findOneOrCreate(['userfk'=>$user->id, 'isPrimary'=>1]);
        if($companyobj->isNewRecord){
                // set defaults
                $companyobj->registeredForGST= 0;
                $companyobj->companyName=$fullname;
                $companyobj->accountName=$fullname;
                $companyobj->email=$user->email;
        }
        $companyobj->save();
        // make sure company address record exists
        $companyaddress = CompanyAddress::findOneOrCreate(['companyfk' => $companyobj->id , 'addresstitle' => 'Default']);
        
        if ($companyaddress->isNewRecord) {
            // set defaults
            $companyaddress->addresstype = 1;
            $companyaddress->contact_name = $fullname;
            $companyaddress->contact_email = $user->email;
            $companyaddress->save();
            }
            // make sure an address exists
                $address = Address::findOneOrCreate(['idaddress' => $companyaddress->idcompanyaddress]);
                $post['Address'] = $post['DriverSignupStep1'];

                $address->load($post);
                $address->setAttributes($address->getattributes());
                $address->save();
                if (!$address->save()) {
                    $error = $address->getFirstError();
                    $this->addError(key($error), current($error));

                    throw new \yii\db\Exception(current($error));
                }

        $companyaddress->addressfk = $address->idaddress;
        $companyaddress->save();

    }


}