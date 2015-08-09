<?php

namespace frontend\models;

use common\models\User;
use common\models\UserHasStore;
use frontend\models\Exception\UserStoreOwnerUndefinedException;
use yii\base\Model;
use common\models\State;
use common\models\Store;
use yii\web\UploadedFile;
use common\models\BusinessType;
use common\models\Image;
/**
 * Store form
 *
 */
class StoreForm extends Model
{
    public $id;
    public $title;
    public $businessTypeId;
    public $paymentScheduleId;
    public $website;
    public $businessHours;
    public $storeProfile;
    public $image;
    public $imageFile;
    public $ownerid;
    
    public $companyid; //billing account from select list of owner's companies
    public $block_or_unit;
    public $street_number;
    public $route;
    public $locality;
    public $administrative_area_level_1;
    public $postal_code;
    public $country;
    public $formatted_address;
    public $latitude;
    public $longitude;
    public $googleplaceid;
    public $googleobj;
    
    public $contact_name;
    public $contact_phone;
    public $contact_email;
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id', 'title', 'businessTypeId','companyid',
                    'paymentScheduleId', 'website', 'businessHours',
                    'block_or_unit', 'street_number', 'route', 'locality', 'administrative_area_level_1', 'postal_code', 'country',
                    'formatted_address','latitude','longitude','googleplaceid','googleobj',
                    'contact_name','contact_phone','contact_email',
                     'storeProfile', 'image', 'imageFile'
                ],
                'safe'
            ],
            [['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png, gif']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Store Name',
            'administrative_area_level_1' => 'State',
            'locality' => 'Suburb',
            'companyid' => 'Billing Account'
        ];
    }

    /**
     * Set data from StoreOwner
     * @param int $storeId
     */
    public function setData($storeId)
    {
        $store = Store::findOne($storeId);
        $this->setAttributes($store->getAttributes());
        // TODO: add the other tables (make a view?)
        $this->image = $store->image;
    }

    public function initializeForm(User $user){
            $storeOwner = $this->getUserStoreOwner($user);

           // var_dump($owner); die;
            // get owner's deets. this should always return a result
            $this->ownerid = $storeOwner->userId;
            $storeOwnerView = \common\models\StoreownerView::findOne(['id'=>$storeOwner->userId]);
            // set defaults from current user 
            $this->contact_name = $storeOwnerView->firstName.' '.$storeOwnerView->lastName;
            $this->contact_email= $storeOwnerView->email;
            $this->contact_phone= $storeOwnerView->contact_phone;
    }




    /**
     * Save
     * @param User $user storeOwner
     */
    public function save($user)
    {
        if (!$this->id) {
            $store = new Store(); //unfinished
            // get the store owner rather that current user in case current user is manager
            $userStoreOwner = $this->getUserStoreOwner($user);
            $store->storeOwnerId = $userStoreOwner->id;
            $store->paymentScheduleId=1;
            $store->setAttributes($this->getAttributes());
            $store->createdAt = time();
            $store->updatedAt = time();
            if($store->save()){
                
            }else{
                $error = $store->getFirstError();
                $this->addError(key($error), current($error));
                var_dump(current($error));
                throw new \yii\db\Exception(current($error));
                
                
            }
        } else {
            $store = Store::findOne($this->id);
            $store->setAttributes($this->getAttributes());
            $store->save();
        }
        // update or insert the store
        $image = new Image();
        $image->save();
        $image->imageFile = UploadedFile::getInstance($this, 'imageFile');
        if ($image->imageFile) {
            $image->saveFiles();
            $image->save();
            $store->imageId = $image->id;
        }
        // update the image;
        $store->save();
        
        $relation = UserHasStore::find()
                ->where([
                    'userId' => $userStoreOwner->id,
                    'storeId' => $store->id
                ])
                ->one();
        if(!$relation){
             $rel = new UserHasStore();
             $rel->storeId = $store->id;
             $rel->userId =  $userStoreOwner->id;
             $rel->save();            
        }
        
        // make sure there is a store address
        $storeaddress = \common\models\StoreAddress::findOne(['storefk'=>$store->id]);
        if(!$storeaddress){
            // create the address first to insure relationship integrity
            $address = new \common\models\Address();
            $address->setAttributes($this->getAttributes());
            $address->save();
            $storeaddress = new \common\models\StoreAddress();
            $storeaddress->addressfk=$address->idaddress;
            $storeaddress->save();
        }else{
            // address should already exist
            $address = \common\models\Address::findOne(['idaddress'=>$storeaddress->addressfk]);
            $address->setAttributes($this->getAttributes());
            $address->save();
        }
        $storeaddress->setAttributes($this->getAttributes());
        
        
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


}