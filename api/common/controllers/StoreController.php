<?php
/**
 * Restful store controller
 */

namespace api\common\controllers;


class StoreController extends BaseActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = '@api\common\models\view_stores';
}