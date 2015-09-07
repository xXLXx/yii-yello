<?php

namespace common\models\query;

use common\models\DriverHasStore;

/**
 * This is the ActiveQuery class for [[\common\models\DriverHasStore]].
 *
 * @see \common\models\DriverHasStore
 */
class DriverHasStoreQuery extends BaseQuery
{
    /**
     * @inheritdoc
     * @return \common\models\DriverHasStore[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\DriverHasStore|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Only those accepted by driver.
     *
     * @return static
     */
    public function accepted()
    {
        return $this->andWhere(['isAcceptedByDriver' => '1']);
    }

    /**
     * filters all driverhasstore of current store
     *
     * @return self
     */
    public function ofCurrentStore()
    {
        $storeOwner = \Yii::$app->user->identity->storeOwner;
        $currentStore = $storeOwner->storeCurrent;
        return $this->andWhere([
            DriverHasStore::tableName() . '.storeId'    => $currentStore->id,
            'isAcceptedByDriver'                        => 1
        ]);
    }
}