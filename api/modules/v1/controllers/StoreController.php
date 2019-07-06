<?php
/**
 * v1-specific restful Store controller
 */
namespace api\modules\v1\controllers;

use api\modules\v1\filters\Auth;

class StoreController extends \api\common\controllers\StoreController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\modules\v1\models\Store';

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