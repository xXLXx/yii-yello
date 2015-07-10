<?php
namespace frontend\controllers;

use yii\web\Controller;

/**
 * Class StoreEditController
 * @package frontend\controllers
 *
 * @author belkin
 */

class StoreEditController extends Controller
{
    /**
     * Edit Store page
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}