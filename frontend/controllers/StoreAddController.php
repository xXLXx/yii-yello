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
        if ($model->load($post)) {
            if ($model->validate()) {
                $model->save($user);
                //return \Yii::$app->getResponse()->redirect(['your-stores/index']);
                return $this->render('index', compact('model'));
            }else{
                return $this->render('index', compact('model'));
                // redirect to stores
            }
        } else {
                $model->initializeForm($user);
        }
        
        return $this->render('index', compact('model'));
    }
}