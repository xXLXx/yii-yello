<?php

namespace frontend\models;

use common\models\Address;
use common\models\StoreAddress;
use common\models\StoresView;
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
    
    public $companyId; //billing account from select list of owner's companies
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
                    'id', 'title', 'businessTypeId','companyId',
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
            'companyId' => 'Billing Account'
        ];
    }

    /**
     * Set data from StoreOwner
     *
     * @param int $storeId
     */
    public function setData($storeId)
    {
        $store = StoresView::findOne(['id' => $storeId]);
        $this->setAttributes($store->getAttributes());
        $this->image = Image::findOne($store->imageId);
    }
//
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
            $image = new Image();
            $image->imageFile = UploadedFile::getInstance($this, 'imageFile');
            if ($image->imageFile) {
                if (!$image->saveFiles()) {
                    $error = $image->getFirstError();
                    $this->addError(key($error), current($error));

                    throw new \yii\db\Exception(current($error));
                }
            }
            $image->save();
            $store = Store::findOneOrCreate(['id' => $this->id]);
            // get the store owner rather than current user in case current user is manager
            $userStoreOwner = $this->getUserStoreOwner($user);
            $store->storeOwnerId = $userStoreOwner->id;
            $store->paymentScheduleId = 1;
            $store->setAttributes($this->getAttributes());
            $store->imageId = $image->id;
            if (!$store->save()) {
                $error = $store->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $userHasStore = UserHasStore::findOneOrCreate(['storeId' => $store->id, 'userId' => $userStoreOwner->id]);
            if (!$userHasStore->save()) {
                $error = $userHasStore->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            if ($store->isNewRecord) {
                $address = new Address();
                $address->setAttributes($this->getAttributes());
                $address->setAttribute('addresstitle', 'Default');
                if (!$address->save()) {
                    $error = $address->getFirstError();
                    $this->addError(key($error), current($error));

                    throw new \yii\db\Exception(current($error));
                }

                $storeaddress = new StoreAddress();
                $storeaddress->addressfk = $address->idaddress;
                $storeaddress->storefk = $store->id;
                $storeaddress->setAttributes($this->getAttributes());
                if (!$storeaddress->save()) {
                    $error = $storeaddress->getFirstError();
                    $this->addError(key($error), current($error));

                    throw new \yii\db\Exception(current($error));
                }
            } else {
                $storeaddress = StoreAddress::findOne(['storefk' => $store->id,'addresstitle'=>'Default']);
                if(!$storeaddress){
                    $storeaddress = new StoreAddress();
                    $storeaddress ->storefk=$store->id;
                    $storeaddress->addressfk=0;
                }
                $storeaddress->setAttributes($this->getAttributes());
                if (!$storeaddress->save()) {
                    $error = $storeaddress->getFirstError();
                    $this->addError(key($error), current($error));

                    throw new \yii\db\Exception(current($error));
                }
                $address = Address::findOne(['idaddress' => $storeaddress->addressfk]);
                if(!$address){
                    $address = new Address();
                }
                    $address->setAttributes($this->getAttributes());
                
                if (!$address->save()) {
                    $error = $address->getFirstError();
                    $this->addError(key($error), current($error));

                    throw new \yii\db\Exception(current($error));
                }

                $storeaddress->addressfk=$address->idaddress;

                if (!$storeaddress->save()) {
                    $error = $storeaddress->getFirstError();
                    $this->addError(key($error), current($error));

                    throw new \yii\db\Exception(current($error));
                }                
                
                }

            
            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
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