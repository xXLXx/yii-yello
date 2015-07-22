<?php
/**
 * v1-specific restful City controller
 */

namespace api\modules\v1\controllers;

use api\modules\v1\filters\Auth;

class CityController extends \api\common\controllers\CityController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\modules\v1\models\City';

    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => Auth::className(),
//        ];
//        return $behaviors;
//    }
    

}