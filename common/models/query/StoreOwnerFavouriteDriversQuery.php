<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\StoreOwnerFavouriteDrivers]].
 *
 * @see \common\models\StoreOwnerFavouriteDrivers
 */
class StoreOwnerFavouriteDriversQuery extends BaseQuery
{
    /**
     * @inheritdoc
     * @return \common\models\StoreOwnerFavouriteDrivers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\StoreOwnerFavouriteDrivers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * filters all storeownerfavouritedrivers of current store
     *
     * @return self
     */
    public function ofCurrentStore()
    {
        $storeOwner = \Yii::$app->user->identity->storeOwner;
        $currentStore = $storeOwner->storeCurrent;
        return $this->andWhere([
            'storefk'   => $currentStore->id
        ]);
    }
}