<?php
/**
 * Restful driver controller
 */

namespace api\common\controllers;


class DriverController extends BaseActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = '@api\common\models\Driver';
}