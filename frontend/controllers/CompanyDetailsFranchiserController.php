<?php

namespace frontend\controllers;

use Yii;

use frontend\models\FranchiserCompanyForm;


class CompanyDetailsFranchiserController extends BaseController
{

    public function actionIndex()
    {
        $post = Yii::$app->request->post();

        $franchiserCompanyForm = new FranchiserCompanyForm();
        if ($franchiserCompanyForm->load($post) && $franchiserCompanyForm->validate() ) {
            $franchiserCompanyForm->save();
        } else {
            /* @var $user \common\models\User */
            $user = Yii::$app->user->identity;
            $franchiser = $user->franchiser;
            if ( $franchiser ) {
                $franchiserCompanyForm->setData($franchiser);
            }
        }

        return $this->render('index', [
            'model' => $franchiserCompanyForm,
        ]);
    }

}
