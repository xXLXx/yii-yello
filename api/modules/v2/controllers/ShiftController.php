<?php
/**
 * v1-specific restful Shift controller
 */

namespace api\modules\v2\controllers;


class ShiftController extends \api\common\controllers\ShiftController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\modules\v2\models\Shift';
}