<?php

namespace frontend\models;

use common\models\User;
use common\models\UserDriver;
use common\models\Company;
use common\models\CompanyAddress;
use common\models\Address;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Image;
/**
 * Store form
 *
 */
class DriverSignupStep1 extends Model
{
    // company record - all other company info is hardcoded for signup
    public $id; // storeid
    
    // company address
    public $emergencyContactName;
    public $emergencyContactPhone;
    public $personalProfile;
    
    public $block_or_unit;
    public $street_number;
    public $route;
    public $locality;
    public $administrative_area_level_1;
    public $postal_code;
    public $country;
    public $imageFile;
    public $formatted_address;
    public $latitude;
    public $longitude;
    public $googleplaceid;
    public $googleobj;
    public $utcOffset;
    public $timezone;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'emergencyContactName', 'emergencyContactPhone'
                ],
                'required'
            ],
            [
                'emergencyContactPhone', 'number'
            ],
            [
                [
                    'id', 
                    'emergencyContactName', 'emergencyContactPhone', 'personalProfile',
                    'block_or_unit', 'street_number', 'route', 'locality', 'administrative_area_level_1', 'postal_code', 'country',
                    'formatted_address', 'latitude', 'longitude','googleplaceid','googleobj', 'utcOffset', 'timezone'
                ],
                'safe'
            ]

            
            ];
    }

    public function attributeLabels()
    {
        $labels = [
            'street_number' => '',
            'route' => '',
            'companyname'=>'Company Name',
            'block_or_unit'=>'',
            'administrative_area_level_1'=> \Yii::t('app', 'State'),
            'postal_code'=> \Yii::t('app', 'Postcode'),
            'locality'=> \Yii::t('app', 'Suburb'),
            'emergencyContactName'=> \Yii::t('app', 'Name'),
            'emergencyContactPhone'=> \Yii::t('app', 'Phone'),
            'personalProfile'=> \Yii::t('app','')
            
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }    
        
    
    
 function saveStep1(User $user)
    {
//        if (!$this->validate()) {
//            return false;
//        }

        $transaction = \Yii::$app->db->beginTransaction();
            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt',PHP_EOL.PHP_EOL.'=================='.PHP_EOL.'    Personal Info Save webapp signup    '.PHP_EOL.'==============='.PHP_EOL, FILE_APPEND);
         
       try {
            $fullname = (string)  $user->firstName.' '.(string)$user->lastName;
            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt','---------------------------------------'.PHP_EOL.'    Full name created:     '.$fullname.PHP_EOL , FILE_APPEND);
            file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export(  PHP_EOL.'FindOrCreate userdriver' . PHP_EOL, true), FILE_APPEND);
            
            $userDriver = UserDriver::findOneOrCreate(['userId' => $user->id]);
           // file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export(  PHP_EOL.$userDriver->toArray() . PHP_EOL, true), FILE_APPEND);


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
           
           $imageFile = UploadedFile::getInstance($this, 'imageFile');
           if (!empty($imageFile)) {
               $url = \Yii::$app->storage->uploadFile($imageFile->tempName, str_replace('{id}', $user->id, $user->getProfilePhotoPathPattern()));

               if (empty($url)) {
                   throw new \Exception('Upload failed.');
               }
           }

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