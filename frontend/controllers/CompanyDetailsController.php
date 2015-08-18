<?php

namespace frontend\controllers;

use frontend\models\CompanyForm;

/**
 * Company details controller
 *
 * @author markov
 */
class CompanyDetailsController extends BaseController
{
    /**
     * Company details page
     */
    public function actionIndex()
    {
        $post = \Yii::$app->request->post();
        $companyForm = new CompanyForm();
        if (!$companyForm->load($post) || !$companyForm->save()) {
            $user = \Yii::$app->user->identity;
            $companyForm->setData($user);
        }

        return $this->render('index', [
            'model'     => $companyForm
        ]);
    }
}
