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
    public $address1;
    public $address2;
    public $suburb;
    public $stateId;
    public $contactPerson;
    public $phone;
    public $abn;
    public $website;
    public $email;
    public $businessHours;
    public $storeProfile;
    public $image;
    public $imageFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id', 'title', 'businessTypeId',
                    'paymentScheduleId', 'address1', 'address2',
                    'suburb', 'stateId', 'contactPerson', 'phone', 'abn', 'website', 'email',
                    'businessHours', 'storeProfile', 'image', 'imageFile'
                ],
                'safe'
            ],
            [['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png, gif']
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
        $this->image = $store->image;
    }

    /**
     * Save
     * @param User $user storeOwner
     */
    public function save($user)
    {
        if (!$this->id) {
            $store = new Store();
            $userStoreOwner = $this->getUserStoreOwner($user);
            $store->companyId = $userStoreOwner->company->id;
            $store->storeOwnerId = $userStoreOwner->id;
        } else {
            $store = Store::findOne($this->id);
        }

        $store->setAttributes($this->getAttributes());
        $image = new Image();
        $image->save();
        $image->imageFile = UploadedFile::getInstance($this, 'imageFile');
        if ($image->imageFile) {
            $image->saveFiles();
            $image->save();
            $store->imageId = $image->id;
        }
        $store->save();
        $this->createUserHasStoreRealtion($user, $store);
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