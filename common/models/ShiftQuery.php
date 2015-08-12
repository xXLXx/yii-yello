<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Shift]].
 *
 * @see Shift
 */
class ShiftQuery extends \common\models\query\BaseQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Shift[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Shift|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Un-confirmed as recorded in `shiftcopylog` table
     *
     * @return self
     */
    public function unconfirmed()
    {
        return $this->joinWith([
            'shiftCopyLog' => function ($query) {
                $query->andWhere(['confirmedAt' => '0']);
            }
        ]);

    }

    /**
     * Within a range
     *
     * @return self
     */
    public function within($start, $end)
    {
        return $this
            ->andWhere(['>=', 'start', $start])
            ->andWhere(['<=', 'end', $end]);
    }
}