<?php
namespace frontend\controllers;

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
        return $this->render('index');
    }
}