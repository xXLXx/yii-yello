<?php
namespace frontend\controllers;

use common\models\Role;
use common\models\Store;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Class YourStoresController
 * @package frontend\controllers
 */
class YourStoresController extends Controller
{
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_MANAGER,
                            Role::ROLE_STORE_OWNER,
                            Role::ROLE_SUPER_ADMIN,
                            Role::ROLE_YELLO_ADMIN
                        ]
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => false,
                        'roles' => ['@'],
                    ],

                ],
            ],
        ]);
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'stores' => $this->getUserStoreList(),
        ]);
    }

    /**
     * @return Store[]
     */
    private function getUserStoreList()
    {
        $user = Yii::$app->user->identity;
        return $user->storeOwner ? $user->storeOwner->stores : $user->stores;
    }
}
