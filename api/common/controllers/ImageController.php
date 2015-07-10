<?php
/**
 * Restful image controller
 */

namespace api\common\controllers;


class ImageController extends BaseActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = '@api\common\models\Image';
}