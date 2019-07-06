<?php
/**
 * v1-specific restful Vehicle type controller
 */

namespace api\modules\v1\controllers;

use api\modules\v1\filters\Auth;

class VehicleTypeController extends \api\common\controllers\VehicleTypeController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\modules\v1\models\VehicleType';

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