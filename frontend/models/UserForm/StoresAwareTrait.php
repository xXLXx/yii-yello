<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 17.06.2015
 * Time: 16:49
 */

namespace app\models\UserForm;


use common\models\Role;
use common\models\Store;
use common\models\StoreOwner;
use common\models\User;
use frontend\models\UserForm\StoresAwareUserForm;
use Yii;

/**
 * Class StoresAwareTrait
 * @package app\models\UserForm
 */
trait StoresAwareTrait
{
    public $stores;

    /**
     * @return bool
     */
    public function needToShowStoresField()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $roleName = $user->role->name;
        $hasPerms = in_array($roleName, [
            Role::ROLE_STORE_OWNER,
            Role::ROLE_SUPER_ADMIN
        ]) || ($roleName === Role::ROLE_MANAGER && $user->hasExtendedRights);
        if ($hasPerms && $this instanceof StoresAwareUserForm) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getStoresArrayMap()
    {
        $result = [];
        /** @var User $user */
        $user = Yii::$app->user->identity;

        /** @var StoreOwner $owner */
        $owner = $user->storeOwner;
        if ($owner) {
            foreach ($owner->stores as $store) {
                $result[$store->id] = $store->title;
            }
        }
        return $result;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function saveUserStoreRelations(User $user)
    {
        $user->setStores($this->store);
    }

    public function hasUserStoreRelation($storeId)
    {
        $user = User::findOne($this->id);
        if ($user && $user->stores) {
            foreach ($user->stores as $store) {
                if ($store->id == $storeId) {
                    return true;
                }
            }

        }
        return false;
    }

    public function getTemplate()
    {
        return 'userCreate';
    }

    public function setData($user)
    {
        parent::setData($user);
        $this->stores = $this->getStoresArrayMap();
    }
}