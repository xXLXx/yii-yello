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
                'country', 'latitude', 'longitude', 'googleplaceid', 'formatted_address', 'lat', 'lng', 'placeid'], 'safe'], // safe for now
        ];
    }

    /**
     * Saves driver personal info.
     * 1. Create UserDriver, if one not yet available
     * 2. Create Vehicle, if one not yet available
     * 3. Save imageFile uploaded
     * 4. Create company and its address
     *
     * @inheritdoc
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $fullname = (string)  $this->firstName.' '.(string)$this->lastName;
            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('savePersonal' . PHP_EOL, true), FILE_APPEND);
            $user = \Yii::$app->user->identity;
            $userDriver = UserDriver::findOneOrCreate(['userId' => $user->id]);
            $vehicle = Vehicle::findOneOrCreate(['driverId' => $user->id]);

            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('imagePersonal' . PHP_EOL, true), FILE_APPEND);
            if (isset($_FILES['imageFile'])) {
                $image = new Image();
                $image->imageFile = UploadedFile::getInstanceByName('imageFile');
                if ($image->imageFile) {
                    $image->saveFiles();
                    $image->save();
                    $user->imageId = $image->id;
                    file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($image->imageFile, true), FILE_APPEND);
                }
            }

            $user->firstName = $this->firstName;
            $user->lastName = $this->lastName;
            $user->signup_step_completed = 1;
            if (!$user->save()) {
                $error = $user->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $company = Company::findOneOrCreate(['userfk' =>$user->id, 'isPrimary' => 1]);
            if ($company->isNewRecord) {
                $company->accountName=$this->firstName.' '.$this->lastName;
                $company->email=$user->email;
            }

            // add /update company
            $company->registeredForGST=0;
            $company->companyName=$this->company;
            $company->ABN=$this->abn;
            if (!$company->save()) {
                $error = $company->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            if (!empty($this->lat)) {
                $this->latitude = $this->lat;
            }

            if (!empty($this->lng)) {
                $this->longitude = $this->lng;
            }

            if (!empty($this->googleplaceid)) {
                $this->placeid = $this->googleplaceid;
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

            // @todo: jovani - add logic to figure out timezone and currency

            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($user->toArray(), true), FILE_APPEND);
            $userDriver->setAttributes($this->getAttributes());

            $userDriver->userId = $user->id;
            if (!$userDriver->save()) {
                $error = $userDriver->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($userDriver->getErrors(), true), FILE_APPEND);
            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($vehicle->toArray(), true), FILE_APPEND);
            $this->image = $user->image;
            $this->userId = $user->id;

            $vehicle->driverId = $user->id;
            $vehicle->setAttributes($this->getAttributes());
            if (!$vehicle->save()) {
                $error = $vehicle->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
    }
}