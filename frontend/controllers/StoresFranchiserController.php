<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 25.06.2015
 * Time: 17:05
 */

namespace frontend\controllers;


use common\models\search\StoreSearch;
use Yii;

class StoresFranchiserController extends BaseController
{
    public function actionIndex()
    {
        $searchParams = \Yii::$app->request->getQueryParams();
        $searchModel = new StoreSearch();
        $dataProvider = $searchModel->search($searchParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchParams' => $searchParams
        ]);
    }

    public function actionRequest()
    {
        $this->layout = 'empty';
        return $this->render('request');
    }

}