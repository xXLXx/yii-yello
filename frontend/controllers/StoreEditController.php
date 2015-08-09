<?php
namespace frontend\controllers;

use frontend\models\StoreForm;
use yii\web\Controller;

/**
 * Class StoreEditController
 *
 * @package frontend\controllers
 *
 * @author belkin
 */

class StoreEditController extends Controller
{
    /**
     * Edit Store page
     *
     * @TODO maybe merge with store-add
     */
    public function actionIndex()
    {
        $model = new StoreForm();

        if ($model->load(\Yii::$app->request->post()) && $model->save(\Yii::$app->user->identity)) {
            $this->redirect(['your-stores/index']);
        }

        $model->setData(\Yii::$app->request->get('storeId'));

        // Have to use same page as the store-add for consistency
        return $this->render('/store-add/index', compact('model'));
    }
}