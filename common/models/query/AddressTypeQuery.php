<?php

namespace common\models\query;
use common\models\AddressType;

/**
 * This is the ActiveQuery class for [[\common\models\AddressType]].
 *
 * @see \common\models\AddressType
 */
class AddressTypeQuery extends \yii\db\ActiveQuery
{
    public function byType($type = AddressType::TYPE_POSTAL)
    {
        $this->andWhere(array('addresstype' => $type));
        return $this;
    }

    /**
     * @inheritdoc
     * @return \common\models\AddressType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\AddressType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}