<?php

namespace frontend\controllers;
use common\models\StoreOwner;
use Yii;

/**
 * User add
 *
 * @author markov
 */
class StoreOwnerUserAddController extends BaseController
{
    /**
     * Form manager add
     */
    public function actionIndex($roleId)
    {
        return $this->render('index', [
            'roleId' => $roleId
        ]);
    }
}
