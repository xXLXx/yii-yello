<?php

namespace frontend\models\UserForm;
use common\models\Image;
use common\models\UserDriver;
use common\models\Vehicle;
use common\models\Company;
use common\models\CompanyAddress;
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
    public $company;
    public $abn;

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
            [['block_or_unit', 'street_number', 'route', 'locality', 'administrative_area_level_1', 'postal_code',
                'country', 'latitude', 'longitude', 'googleplaceid', 'lat', 'lng', 'placeid'], 'safe'], // safe for now
        ];
    }

    /**
     * Saves driver personal info.
*/
    
    public function savePersonalInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = \Yii::$app->db->beginTransaction();
            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt',PHP_EOL.PHP_EOL.'=================='.PHP_EOL.'    Personal Info Save    '.PHP_EOL.'==============='.PHP_EOL, FILE_APPEND);
         
        try {
            $fullname = (string)  $this->firstName.' '.(string)$this->lastName;
            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt','---------------------------------------'.PHP_EOL.'    Full name created:     '.$fullname.PHP_EOL , FILE_APPEND);
            $user = \Yii::$app->user->identity;
            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export(  PHP_EOL.'FindOrCreate userdriver' . PHP_EOL, true), FILE_APPEND);
            
            $userDriver = UserDriver::findOneOrCreate(['userId' => $user->id]);
           // file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export(  PHP_EOL.$userDriver->toArray() . PHP_EOL, true), FILE_APPEND);
         

            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export(  PHP_EOL.'Image:' . PHP_EOL, true), FILE_APPEND);
            if (isset($_FILES['imageFile'])) {
                $image = new Image();
                $image->imageFile = UploadedFile::getInstanceByName('imageFile');
                if ($image->imageFile) {
                    $image->saveFiles();
                    $image->save();
                    $user->imageId = $image->id;
                    file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export(PHP_EOL.$image->imageFile.PHP_EOL, true), FILE_APPEND);
                }
            }

            $user->firstName = $this->firstName;
            $user->lastName = $this->lastName;
            $user->signup_step_completed = 1;
            if (!$user->save()) {
                $error = $user->getFirstError();
                $this->addError(key($error), current($error));
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export(PHP_EOL.'Problem saving user : '.current($error).PHP_EOL, true), FILE_APPEND);

                throw new \yii\db\Exception(current($error));
            }

                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export(PHP_EOL.'We got as far as company: '.PHP_EOL, true), FILE_APPEND);
            $company = Company::findOneOrCreate(['userfk' =>$user->id, 'isPrimary' => 1]);
            if ($company->isNewRecord) {
                $company->registeredForGST= 0;
                $company->companyName=$fullname;
                $company->accountName=$fullname;
                $company->email=$user->email;
            }

            // add /update company
            if (!$company->save()) {
                $error = $company->getFirstError();
                $this->addError(key($error), current($error));
                throw new \yii\db\Exception(current($error));
            }
            
            $companyaddress = CompanyAddress::findOneOrCreate(['companyfk' => $company->id , 'addresstitle' => 'Default']);
            if ($companyaddress->isNewRecord) {
                $companyaddress->addresstype = 1;
                $companyaddress->contact_name = $fullname;
                $companyaddress->contact_email = $user->email;
                 $address = new Address();
                 $address->setAttributes($this->getAttributes());
                if (!$address->save()) {
                    $error = $address->getFirstError();
                    $this->addError(key($error), current($error));

                    throw new \yii\db\Exception(current($error));
                }
            } else {
                $address = Address::findOneOrCreate(['idaddress' => $companyaddress->idcompanyaddress]);
                $address->setAttributes($this->getAttributes());
                if (!$address->save()) {
                    $error = $address->getFirstError();
                    $this->addError(key($error), current($error));

                    throw new \yii\db\Exception(current($error));
                }
            }

            $companyaddress->addressfk = $address->idaddress;
            if (!$companyaddress->save()) {
                $error = $companyaddress->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt','---------------------------------------'.PHP_EOL.'    Here\'s the CompanyAddress    '.PHP_EOL , FILE_APPEND);
            // @todo: jovani - add logic to figure out timezone and currency

            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt','---------------------------------------'.PHP_EOL.'    Here\'s the User again    '.PHP_EOL , FILE_APPEND);
            $userDriver->setAttributes($this->getAttributes());

            $userDriver->userId = $user->id;
            if (!$userDriver->save()) {
                $error = $userDriver->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt','---------------------------------------'.PHP_EOL.'    Here\'s the UserDriver    '.PHP_EOL , FILE_APPEND);
            
            $this->image = $user->image;
            $this->userId = $user->id;

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export(PHP_EOL.$e->getMessage(), true), FILE_APPEND);
            $transaction->rollBack();
        }

        return false;
    }
    
}