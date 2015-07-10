<?php

namespace frontend\models\UserForm;
use common\models\Image;
use common\models\UserDriver;
use common\models\Vehicle;
use yii\web\UploadedFile;

/**
 * Driver form
 */
class DriverForm extends UserForm
{
    public $cityId;
    public $personalProfile;
    public $emergencyContactName;
    public $emergencyContactPhone;
    public $userId;
    public $address1;
    public $address2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'cityId'], 'integer'],
            [['firstName', 'lastName'], 'filter', 'filter' => 'trim'],
            ['firstName', 'required',
                'message' => \Yii::t('app', 'Please enter your First Name.')
            ],
            ['lastName', 'required',
                'message' => \Yii::t('app', 'Please enter your Last Name.')
            ],
            ['cityId', 'required',
                'message' => \Yii::t('app', 'Please enter your city.')
            ],
            ['address1', 'required',
                'message' => \Yii::t('app', 'Please enter your Address(Line1).')
            ],
            ['address2', 'required',
                'message' => \Yii::t('app', 'Please enter your Address(Line2).')
            ],
            ['personalProfile', 'required',
                'message' => \Yii::t('app', 'Please enter your Personal Profile.')
            ],
            [['address1', 'address2', 'emergencyContactName', 'emergencyContactPhone', 'personalProfile'], 'string', 'max' => 255],
            [['imageFile', 'image'], 'safe'],
            [['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png, gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('savePersonal' . PHP_EOL, true), FILE_APPEND);
        $user = \Yii::$app->user->identity;
        $userDriver = UserDriver::findOne(['userId' => $user->id]);
        if (!$userDriver) {
            $userDriver = new UserDriver();
        }
        $vehicle = Vehicle::findOne(['driverId' => $user->id]);
        if (!$vehicle) {
            $vehicle = new Vehicle();
        }
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('imagePersonal' . PHP_EOL, true), FILE_APPEND);
        if (isset($_FILES['imageFile'])) {
            $image = new Image();
            $image->imageFile = UploadedFile::getInstanceByName('imageFile');
            if ($image->imageFile) {
                $image->save();
                $image->saveFiles();
                $image->save();
                $user->imageId = $image->id;
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($image->imageFile, true), FILE_APPEND);
            }
        }
        $user->firstName = $this->firstName;
        $user->lastName = $this->lastName;
        $user->save();
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($user->toArray(), true), FILE_APPEND);
        $userDriver->setAttributes($this->getAttributes());
        $userDriver->userId = $user->id;
        $userDriver->save();
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($userDriver->getErrors(), true), FILE_APPEND);
        $vehicle->driverId = $user->id;
        $vehicle->save();
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($vehicle->toArray(), true), FILE_APPEND);
        $this->image = $user->image;
        $this->userId = $user->id;
    }
}