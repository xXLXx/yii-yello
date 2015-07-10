<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */
class UserQuery extends BaseQuery
{
    /**
     * @inheritdoc
     * @return \common\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['active' => 1]);
        return $this;
    }
}