<?php
namespace frontend\controllers;

use frontend\models\StoreForm;
use yii\web\Controller;

/**
 * Class StoresAdd
 * @package frontend\controllers
 *
 * @author belkin
 */

class StoreAddController extends Controller
{
    /**
     * Add Store page
     */
    public function actionIndex()
    {
        
        $user = \Yii::$app->user->identity;
        $post = \Yii::$app->request->post();
        $model = new StoreForm();
        
        if ($model->load($post) && $model->save($user)) {
            $this->redirect(['your-stores/index']);
        }
        if(!$model->load($post)){
            $model->initializeForm($user);
        }  else {
            $model->getStoreOwner($user);
        }
        return $this->render('index', compact('model'));
    }
}