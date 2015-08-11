<?php

namespace frontend\models;

use common\models\User;
use common\models\UserDriver;
use common\models\Vehicle;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Image;
/**
 * Store form
 *
 */
class DriverSignupStep2 extends Model
{
    // company record - all other company info is hardcoded for signup
    public $id; // storeid
    
    // company address
    public $vehicleTypeId;
    public $registration;
    
    public $make;
    public $model;
    public $year;
    public $imageId;
    
    public $licenseNumber;
    public $licensePhotoId;

    public $vehiclePhotoFile;
    public $licensePhotoFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'registration', 'make', 'model', 'year','licenseNumber'
                ],
                'required'
            ],
            ['year', 'integer', 'min' => 2000],
            [
                'vehicleTypeId', 'required', 'message' => \Yii::t('app', 'Please select Vehicle Type.')
            ]
        ];
    }

    public function attributeLabels()
    {
        $labels = [
            'vehicleTypeId'=> \Yii::t('app', 'Vehicle Type'), // vehicle types from database - radio buttons
         
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }    
        
    
    
    /**
     * Set data from User/Driver
     *
     * @param \common\models\User $user
     */
    public function setData($user)
    {
        if ($user->vehicle) {
            $this->setAttributes($user->vehicle->getAttributes());
        }
    }

    /**
     * Save this form.
     * The transactional way shall ensure we save this record at once
     * with not a single error.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function save($user)
    {
        if (!$this->validate()) {

            return false;
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {

            $vehicle = new Vehicle();

            if ($user->vehicle) {
                $vehicle = $user->vehicle;
            }

            $vehicle->setAttributes($this->getAttributes());

            $userDriver = UserDriver::findOneOrCreate(['userId' => $user->id]);
            $userDriver->driverLicenseNumber = $this->licenseNumber;

            $imageVehicle = Image::findOneOrCreate(['id' => $vehicle->imageId]);
            $imageVehicle->imageFile = UploadedFile::getInstance($this, 'vehiclePhotoFile');
            if ($imageVehicle->imageFile) {
                if (!$imageVehicle->saveFiles()) {
                    $error = $imageVehicle->getFirstError();
                    $this->addError(key($error), current($error));
                    throw new \yii\db\Exception(current($error));
                }
                $vehicle->imageId = $imageVehicle->id;
            }

            $imageLicense = Image::findOneOrCreate(['id' => $vehicle->licensePhotoId]);
            $imageLicense->imageFile = UploadedFile::getInstance($this, 'licensePhotoFile');
            if ($imageLicense->imageFile) {
                if (!$imageLicense->saveFiles()) {
                    $error = $imageLicense->getFirstError();
                    $this->addError(key($error), current($error));
                    throw new \yii\db\Exception(current($error));
                }
                $vehicle->licensePhotoId = $imageLicense->id;
                $userDriver->driverLicensePhoto = $imageLicense->originalUrl;
            }

            if (!$userDriver->save()) {
                $error = $userDriver->getFirstError();
                $this->addError(key($error), current($error));
                throw new \yii\db\Exception(current($error));
            }

            if (!$vehicle->save()) {
                $error = $vehicle->getFirstError();
                $this->addError(key($error), current($error));
                throw new \yii\db\Exception(current($error));
            }

            $user->signup_step_completed = 2;
            $user->save(false);

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
    }
}