<?php
namespace frontend\widgets\StoreSwitch;

use common\models\Store;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Class StoreSwitchWidget
 *
 * @package frontend\widgets\StoreSwitch
 */
class StoreSwitchWidget extends Widget
{
    /**
     * User
     *
     * @var \common\models\User
     */
    public $user;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $stores = $this->getUserStoreList();
        if (!$stores) {
            return false;
        }

        $currentStore = $this->getCurrentUserStore();
        if (!$currentStore) {
            return false;
        }

        return $this->render('default', [
           'stores'         => $stores,
           'storeCurrent'   => $currentStore,
           'redirectUrl'    => Url::to(['shifts-calendar/index'])
        ]);
    }

    /**
     * @return \common\models\Store[]|mixed
     */
    private function getUserStoreList()
    {
        $storeOwner = $this->user->storeOwner;
        return ($storeOwner) ? $storeOwner->stores : $this->user->stores;
    }

    /**
     * @return Store
     */
    private function getCurrentUserStore()
    {
        $storeOwner = $this->user->storeOwner;
        return ($storeOwner) ? $storeOwner->storeCurrent : $this->user->storeCurrent;
    }
}