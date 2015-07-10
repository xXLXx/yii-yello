<?php
/**
 * v1-specific restful Image controller
 */

namespace api\modules\v1\controllers;

use api\modules\v1\filters\Auth;

class ImageController extends \api\common\controllers\ImageController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\modules\v1\models\Image';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => Auth::className(),
        ];
        return $behaviors;
    }
}