<?php
/**
 * Restful shiftstate controller
 */

namespace api\common\controllers;
use api\common\models\ShiftState;

/**
 * Class ShiftController
 * @package api\common\controllers
 *
 * @method ShiftState findModel(integer $id)
 */

class ShiftStateController extends BaseActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = '@api\common\models\ShiftState';
}