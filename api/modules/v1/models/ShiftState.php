<?php
/**
 * v1-specific restful model for ShiftState
 */

namespace api\modules\v1\models;


class ShiftState extends \api\common\models\ShiftState
{
    public function extraFields()
    {
        return ['shifts'];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'name',
            'title',
            'color',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function shiftClass()
    {
        return Shift::className();
    }
}