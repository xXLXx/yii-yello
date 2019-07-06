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
        ], true, 'RIGHT JOIN');

    }

    /**
     * Filter by store id.
     *
     * @param int $storeId
     * @return static
     */
    public function byStore($storeId)
    {
        return $this->andWhere(['storeId' => $storeId]);
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

    /**
     * filters all shifts for currenlty logged in storeowner
     *
     * @return self
     */
    public function ofCurrentStore()
    {
        $storeOwner = \Yii::$app->user->identity->storeOwner;
        $currentStore = $storeOwner->storeCurrent;
        return $this->andWhere(['storeId' => $currentStore->id]);
    }

    /**
     * filters all completed shifts
     *
     * @return self
     */
    public function completed()
    {
        return $this->withState(ShiftState::STATE_COMPLETED);
    }

    /**
     * filters all pending shifts
     *
     * @return self
     */
    public function pending()
    {
        return $this->withState(ShiftState::STATE_PENDING);
    }

    /**
     * filters all active shifts
     *
     * @return self
     */
    public function active()
    {
        return $this->withState(ShiftState::STATE_ACTIVE);
    }

    /**
     * filters all yello allocated shifts
     *
     * @return self
     */
    public function yelloAllocated()
    {
        return $this->withState(ShiftState::STATE_YELLO_ALLOCATED);
    }

    /**
     * filters all allocated shifts
     *
     * @return self
     */
    public function allocated()
    {
        return $this->withState(ShiftState::STATE_ALLOCATED);
    }

    /**
     * filters all shifts with $state state name
     *
     * @return self
     *
     * @param $state the state constant from common\models\ShiftState;
     */
    public function withState($state)
    {
        $shiftState = ShiftState::findOne(['name' => $state]);
        return $this->andWhere(['shiftStateId' => $shiftState->id]);
    }
}