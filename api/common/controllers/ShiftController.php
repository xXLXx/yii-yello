<?php
/**
 * Restful shift controller
 */

namespace api\common\controllers;
use api\common\models\Shift;

/**
 * Class ShiftController
 * @package api\common\controllers
 *
 * @method Shift findModel(integer $id)
 */

class ShiftController extends BaseActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = '@api\common\models\Shift';
}