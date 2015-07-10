<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ShiftStateLog]].
 *
 * @see \common\models\ShiftStateLog
 */
class ShiftStateLogQuery extends BaseQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\ShiftStateLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\ShiftStateLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}