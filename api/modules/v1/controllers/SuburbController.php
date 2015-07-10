<?php
/**
 * v1-specific restful Suburb controller
 */

namespace api\modules\v1\controllers;

use api\modules\v1\filters\Auth;
use common\models\Suburb;

class SuburbController extends \api\common\controllers\SuburbController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\modules\v1\models\Suburb';

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

    public function actionCity($id)
    {
        return Suburb::findAll(['cityId' => $id]);
    }
}