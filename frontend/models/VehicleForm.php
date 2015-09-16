<?php

namespace frontend\models;
use common\models\Image;
use common\models\UserDriver;
use common\models\Vehicle;
use yii\web\UploadedFile;
use yii\base\Model;

/**
 * Vehicle form
 */
class VehicleForm extends Model
{
    public $vehicleTypeId;
    public $registration;
    public $make;
    public $model;
    public $year;
    public $licenseNumber;
    public $licensePhoto;
    public $licensePhotoFile;
    public $vehiclePhoto;
    public $vehiclePhotoFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicleTypeId'], 'integer'],
            ['vehicleTypeId', 'required',
                'message' => \Yii::t('app', 'Please enter Vehicle Type.')
            ],
            ['registration', 'required',
                'message' => \Yii::t('app', 'Please enter Registration.')
            ],
            ['make', 'required',
                'message' => \Yii::t('app', 'Please enter Make.')
            ],
            ['year', 'required',
                'message' => \Yii::t('app', 'Please enter Model.')
            ],
            ['licenseNumber', 'required',
                'message' => \Yii::t('app', 'Please enter Year.')
            ],
            [['registration', 'make', 'model', 'year'], 'string', 'max' => 255],
            [['licensePhoto', 'licensePhotoFile', 'vehiclePhoto', 'vehiclePhotoFile'], 'safe'],
            [['licensePhotoFile', 'vehiclePhotoFile'], 'file', 'extensions' => 'jpg, jpeg, png, gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    // USED BY API V1
    public function save()
    {
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('saveVehicle' . PHP_EOL, true), FILE_APPEND);
        $user = \Yii::$app->user->identity;
        $vehicle = Vehicle::findOneOrCreate(['driverId' => $user->id]);
        $userDriver = UserDriver::findOne(['userId' => $user->id]);
        if (!$userDriver) {
            $userDriver = new UserDriver();
        }
        $vehicle->setAttributes($this->getAttributes());
//        if (isset($_FILES['vehiclePhotoFile'])) {
//        $image = new Image();
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('vehiclePhotoFile' . PHP_EOL, true), FILE_APPEND);
        $vehiclePhotoFile = UploadedFile::getInstanceByName('vehiclePhotoFile');
        if (!empty($vehiclePhotoFile)) {
            $user->uploadVehiclePhoto($vehiclePhotoFile->tempName);
        }
//        if ($image->imageFile) {
//            $image->saveFiles();
//            $image->save();
//            $vehicle->imageId = $image->id;
//        }
//        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($image->imageFile, true), FILE_APPEND);
//        }
        $userDriver->driverLicenseNumber = $this->licenseNumber;
//            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('licensePhotoFile' . PHP_EOL, true), FILE_APPEND);
//        $image = new Image();
        $licensePhotoFile = UploadedFile::getInstanceByName('licensePhotoFile');
        if (!empty($licensePhotoFile)) {
            $user->uploadLicensePhoto($licensePhotoFile->tempName);
        }
//        if ($image->imageFile) {
//            $image->saveFiles();
//            $image->save();
//            $vehicle->licensePhotoId = $image->id;
//            $userDriver->driverLicensePhoto = $image->id;
//        }
//                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($image->imageFile, true), FILE_APPEND);

        $vehicle->save();
        $this->licensePhoto = $vehicle->licensePhoto;
        $this->vehiclePhoto = $vehicle->image;
        $userDriver->save();
                    if($user->signup_step_completed<2){
                        $user->signup_step_completed = 2;
                    }
        $user->save();
//        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($vehicle->toArray(), true), FILE_APPEND);
//        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($vehicle->getErrors(), true), FILE_APPEND);

    }
}