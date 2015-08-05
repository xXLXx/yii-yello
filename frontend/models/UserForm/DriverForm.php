<?php

namespace frontend\models\UserForm;
use common\models\Image;
use common\models\UserDriver;
use common\models\Vehicle;
use common\models\Company;
use common\models\CompanyAddress;
use common\models\Companytype;
use common\models\Address;
use yii\web\UploadedFile;

/**
 * Driver form
 */
class DriverForm extends UserForm
{
    public $personalProfile;
    public $emergencyContactName;
    public $emergencyContactPhone;
    public $userId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId'], 'integer'],
            [['firstName', 'lastName'], 'filter', 'filter' => 'trim'],
            ['firstName', 'required',
                'message' => \Yii::t('app', 'Please enter your First Name.')
            ],
            ['lastName', 'required',
                'message' => \Yii::t('app', 'Please enter your Last Name.')
            ],
            ['personalProfile', 'required',
                'message' => \Yii::t('app', 'Please enter your Personal Profile.')
            ],
            [['emergencyContactName', 'emergencyContactPhone', 'personalProfile'], 'string', 'max' => 255],
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
        $company = Company::findOne(['userfk'=>$user->id, 'isPrimary'=>1]);
        if(!$company){
            $company = new Company();
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
        
        // add company
        $compnay->userfk = $user->id;
        $company->isPrimary=1;
        $company->registeredForGST=0;
        $company->accountName=$this->firstName.' '.$this->lastName;
        $company->companyName=$this->company;
        $company->ABN->$this->abn;
        
               
        
        
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