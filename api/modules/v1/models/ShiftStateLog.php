<?php

namespace api\modules\v1\models;

/**
 * Class ShiftStateLog
 *
 * v1-specific Restful ShiftStateLog model
 *
 * @package api\modules\v1\models
 */

class ShiftStateLog extends \api\common\models\ShiftStateLog
{
    /**
     * @inheritdoc
     */
    protected static $_namespace = __NAMESPACE__;

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'shift',
            'shiftState',
        ];
    }
}