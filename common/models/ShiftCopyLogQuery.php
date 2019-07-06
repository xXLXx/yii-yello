<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ShiftCopyLog]].
 *
 * @see ShiftCopyLog
 */
class ShiftCopyLogQuery extends \common\models\query\BaseQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ShiftCopyLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShiftCopyLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Filter by params
     *
     * @param array $params should be ['start', 'end', 'storeId', 'period']
     *
     * @return self
     */
    public function byParams($params = [])
    {
        $hashParams = [
            $params['start'],
            $params['end'],
            $params['storeId'],
            $params['period']
        ];
        $hash = md5(implode('/', $hashParams));

        return $this->andWhere(['hash' => $hash]);
    }
}