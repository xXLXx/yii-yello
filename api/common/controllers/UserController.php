<?php
/**
 * Restful User controller
 */

namespace api\common\controllers;


use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
//    public $modelClass = 'api\common\models\User';

    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => HttpBasicAuth::className(),
//        ];
//        return $behaviors;
//    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
        \Yii::$app->user->loginUrl = null;
    }
}