<?php
/**
 * Rest model for Shift
 */

namespace api\common\models;

/**
 * Class Shift
 * @package api\common\models
 *
 * @property ShiftState $shiftState
 * @property ShiftStateLog[] $shiftStateLogs Shift state log rows
 */
class Shift extends \common\models\Shift
{
    /**
     * @inheritdoc
     */
    protected static $_namespace = __NAMESPACE__;

    /**
     * @inheritdoc
     */
//    public function getShiftState()
//    {
//        return $this
//            ->hasOne(
//                ShiftState::className(),
//                [
//                    'id' => 'shiftStateId',
//                ]
//            );
//    }
}