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
        if ($companyForm->load($post)) {
            if ($companyForm->validate()) {
                $companyForm->save();
            }
        } else {
            // TODO: change code to get info rom new tables:
            // 
            
            $user = \Yii::$app->user->identity;
            $companyForm->setData($user->storeOwner);
        }
        return $this->render('index', [
            'model'     => $companyForm
        ]);
    }
}
