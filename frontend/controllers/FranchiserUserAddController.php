<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 25.06.2015
 * Time: 10:37
 */

namespace frontend\controllers;


class FranchiserUserAddController extends BaseController
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