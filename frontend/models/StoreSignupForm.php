<?php

namespace frontend\models;

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
    public $companyid;
    public $companyname;
    public $abn;
    
    // company address
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
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id', 'companyid', 'companyname', 'abn',
                    'contact_email', 'contact_phone', 'contact_name',
                    'block_or_unit', 'street_number', 'route', 'locality', 'administrative_area_level_1', 'postal_code', 'country',
                    'formatted_address'
                ],
                'safe'
            ]
            ,['companyname', 'required', 
                'message' => \Yii::t('app', 'Please enter company name.')
            ]
            ,['abn', 'required', 
                'message' => \Yii::t('app', 'Please enter company ABN.')
            ]
            ,['contact_email', 'email', 
                'message' => \Yii::t('app', 'Please enter a valid email.')
            ]
            ,['contact_phone', 'required', 
                'message' => \Yii::t('app', 'Please enter a phone number.')
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
            'locality'=> \Yii::t('app', 'Suburb')
            
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }    
        
    
    
    /**
     * Set data from StoreOwner
     * @param int $storeId
     */
    public function setData(User $user)
    {
        $company = $this->getUserPrimaryCompany($user);
    }

    /**
     * Save
     * @param User $user storeOwner
     */
    public function save($user)
    {
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