<?php

namespace common\models\query;

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
}