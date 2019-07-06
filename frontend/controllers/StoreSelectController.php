<?php
namespace frontend\controllers;

use common\models\User;
use yii\web\Controller;

/**
 * Class StoreSelectController
 * @package frontend\controllers
 *
 * @author belkin
 */

class StoreSelectController extends Controller
{
    /**
     * Select store by ajax
     */
    public function actionIndex()
    {
        $selectedStoreId = \Yii::$app->request->post('storeId');
        /** @var User $user */
        $user = \Yii::$app->user->identity;
        $user->setStoreCurrentById($selectedStoreId);
        return true;
    }
}