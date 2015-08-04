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
        $model = new StoreForm();

        return $this->render('index', compact('model'));
    }
}