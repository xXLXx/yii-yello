<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[StoreownerView]].
 *
 * @see StoreownerView
 */
class StoreownerViewQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return StoreownerView[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StoreownerView|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}