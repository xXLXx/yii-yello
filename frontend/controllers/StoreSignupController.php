<?php

namespace frontend\controllers;


/**
 * Company details controller
 *
 * @author pottie
 */
class StoreSignupController extends BaseController
{
    /**
     * Company details page
     */
    public function actionIndex()
    {
        $this->layout='signup';
        $user = \Yii::$app->user->identity;
        $post = \Yii::$app->request->post();
        $storeSignupForm = new \frontend\models\StoreSignupForm();
        if ($storeSignupForm->load($post)) {
        } else {
            // TODO: change code to get info rom new tables:
            $user = \Yii::$app->user->identity;
            //$storeSignupForm->setData($user);
        }
        return $this->render('index', [
            'model'     => $storeSignupForm
        ]);
    }
    
    public function actionStepTwo(){
        $this->layout='signup';
        $user = \Yii::$app->user->identity;
        $post = \Yii::$app->request->post();
        $storeSignupForm = new \frontend\models\SignupStorePaymentDetails();
        if ($storeSignupForm->load($post)) {
        } else {
            // TODO: change code to get info rom new tables:
        }
        return $this->render('steptwo', [
            'model'     => $storeSignupForm
        ]);
    }
    
}
