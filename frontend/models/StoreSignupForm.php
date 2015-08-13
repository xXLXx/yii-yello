<?php

namespace frontend\models;

use common\models\Address;
use common\models\Company;
use common\models\CompanyAddress;
use common\models\User;
use common\models\UserHasStore;
use frontend\models\Exception\UserStoreOwnerUndefinedException;
use yii\base\Model;
use common\models\Store;
use yii\web\UploadedFile;
use common\models\BusinessType;
use common\models\Image;
/**
 * Store form
 *
 */
class StoreSignupForm extends Model
{
    // company record - all other company info is hardcoded for signup
    public $id; // storeid
    public $companyId;
    public $companyName;
    public $ABN; // to be consistent with the table field.
    
    // company address
    public $addressfk;
    public $contact_email;
    public $contact_phone;
    public $contact_name;
    
    public $block_or_unit;
    public $street_number;
    public $route;
    public $locality;
    public $administrative_area_level_1;
    public $postal_code;
    public $country;
    public $formatted_address;
    public $googleplaceid;
    public $googleobj;
    public $latitude;
    public $longitude;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['companyName', 'required',
                'message' => \Yii::t('app', 'Please enter company name.')
            ]
            ,['ABN', 'required',
                'message' => \Yii::t('app', 'Please enter company ABN.')
            ]
            ,['contact_email', 'email', 
                'message' => \Yii::t('app', 'Please enter a valid email.')
            ]
            ,['contact_phone', 'required', 
                'message' => \Yii::t('app', 'Please enter a phone number.')
            ],
            [
                [
                    'id', 'companyId', 'companyName', 'ABN',
                    'contact_email', 'contact_phone', 'contact_name',
                    'block_or_unit', 'street_number', 'route', 'locality', 'administrative_area_level_1',
                    'postal_code', 'country', 'formatted_address', 'googleplaceid', 'googleobj', 'addressfk',
                    'latitude', 'longitude',
                ],
                'safe'
            ],
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
            'locality'=> \Yii::t('app', 'Suburb')
            
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }    
        
    
    
//    /**
//     * Set data from StoreOwner
//     * @param int $storeId
//     */
//    public function setData(User $user)
//    {
//        $company = $this->getUserPrimaryCompany($user);
//        if ($company) {
//            $this->setAttributes($company->getAttributes());
//            $this->companyId = $company->id;
//        }
//    }

    /**
     * Save data from step-one
     *
     * @param \common\models\User $user
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
            $company = Company::findOneOrCreate(['id' => $this->companyId]);
            $company->setAttributes($this->getAttributes());
            $company->accountName=$user->firstName.' '.$user->lastName;
            $company->userfk = $user->id;
            $company->email=$user->email;
            $company->isPrimary = 1;
            if (!$company->save()) {
                $error = $company->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }
            $this->companyId = $company->id;

            $address = Address::findOneOrCreate(['idaddress' => $this->addressfk]);
            $address->setAttributes($this->getAttributes());
            if (!$address->save()) {
                $error = $address->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }
            $this->addressfk = $address->idaddress;

            $companyAddress = CompanyAddress::findOneOrCreate(['companyfk' => $company->id, 'addressfk' => $address->idaddress, 'addresstitle'=>'Default','addresstype'=>1]);
            $companyAddress->setAttributes($this->getAttributes());
            $companyAddress->contact_name=$user->firstName.' '.$user->lastName;
            $companyAddress->contact_email=$user->email;
            if (!$companyAddress->save()) {
                $error = $companyAddress->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $user->signup_step_completed = 1;
            $user->save(false);

            $transaction->commit();

            return true;

        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
//        if (!$this->id) {
//            $store = new Store();
//            $userStoreOwner = $this->getUserStoreOwner($user);
//            $store->companyId = $userStoreOwner->company->id;
//            $store->storeOwnerId = $userStoreOwner->id;
//        } else {
//            $store = Store::findOne($this->id);
//        }
//
//        $store->setAttributes($this->getAttributes());
//        $image = new Image();
//        $image->save();
//        $image->imageFile = UploadedFile::getInstance($this, 'imageFile');
//        if ($image->imageFile) {
//            $image->saveFiles();
//            $image->save();
//            $store->imageId = $image->id;
//        }
//        $store->save();
//        $this->createUserHasStoreRealtion($user, $store);
    }

    public function loadData($user)
    {
        $company = $user->company;
        if ($company) {
            $this->setAttributes($company->getAttributes());
            $this->companyId = $company->id;

            if ($company->address) {
                $this->setAttributes($company->address->getAttributes());
                $this->setAttributes($company->companyAddress->getAttributes());
            }
        }
    }


    /**
     * Get business type
     *
     * @return array
     */
    public function getBusinessTypeArrayMap()
    {
        $businessTypes = BusinessType::find()
            ->select(['id', 'title'])
            ->asArray()
            ->all();
        $result = [
            null => \Yii::t('app', 'Select business type')
        ];
        foreach ($businessTypes as $item) {
            $result[$item['id']] = $item['title'];
        }
        return $result;
    }


    /**
     * Get states
     *
     * @return array
     */
    public function getStateArrayMap()
    {
        $states = State::find()
            ->select(['id', 'title'])
            ->asArray()
            ->all();
        $result = [
            null => \Yii::t('app', 'Select state')
        ];
        foreach ($states as $item) {
            $result[$item['id']] = $item['title'];
        }
        return $result;
    }

    /**
     * @param User $user
     * @return \common\models\StoreOwner
     * @throws UserStoreOwnerUndefinedException
     */
    private function getUserStoreOwner(User $user)
    {
        if ($user->storeOwner) {
            return $user->storeOwner;
        }

        if ($user->parentUser && $user->parentUser->storeOwner) {
            return $user->parentUser->storeOwner;
        }

        throw new UserStoreOwnerUndefinedException($user, 'Cannot detect storeOwner');
    }

    /**
     * @param User $user
     * @return \common\models\StoreOwner
     * @throws UserStoreOwnerUndefinedException
     */
    private function getUserPrimaryCompany(User $user)
    {
        if ($user->company) {
            return $user->company;
        }
        throw new UserStoreOwnerUndefinedException($user, 'Cannot detect company');
    }

    /**
     * Save relation between user & store if user is not storeOwner (if he is manager || yelloAdmin)
     *
     * @param User $user
     * @param Store $store
     *
     * @return void
     */
    private function createUserHasStoreRealtion(User $user, Store $store)
    {
        if (!$user->storeOwner) {
            $relation = UserHasStore::find()
                ->where([
                    'userId' => $user->id,
                    'storeId' => $store->id
                ])
                ->one();
            if ($relation) {
                return;
            }

            $relation = new UserHasStore();
            $relation->storeId = $store->id;
            $relation->userId = $user->id;
            $relation->save();
        }
    }
}