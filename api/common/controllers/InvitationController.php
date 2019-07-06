<?php

namespace api\common\controllers;

/**
 * Class InvitationController
 *
 * Restful DriverHasStore controller
 *
 * @package api\common\controllers
 */

class InvitationController extends  BaseActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\common\models\DriverHasStore';
}