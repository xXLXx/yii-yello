<?php

namespace frontend\controllers;

use common\models\Role;
use yii\filters\AccessControl;


/**
 * Company details controller
 *
 * @author pottie
 */
class StoreSignupController extends BaseController
{
    public function init()
    {
        parent::init();

        $this->layout = 'signup';
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Role::ROLE_STORE_OWNER]
                    ],
                ],
            ],
        ]);
    }

    /**
     * Company details page
     */
    public function actionIndex()
    {
        $user = \Yii::$app->user->identity;
        $post = \Yii::$app->request->post();
        $model = new \frontend\models\StoreSignupForm();

        if ($model->load($post) && $model->saveStepOne($user)) {
            $this->redirect(['step-two']);
        } else {
            $model->loadStepOne($user);
        }

        return $this->render('index', [
            'model'     => $model
        ]);
    }
    
    public function actionStepTwo(){
        // cannot use address widget
        
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

    public function actionStepThree(){
        $this->layout='signup';
        $user = \Yii::$app->user->identity;
        $post = \Yii::$app->request->post();
        $storeSignupFirstStoreForm = new \frontend\models\SignupStoreFirstStore();
        if ($storeSignupFirstStoreForm->load($post)) {
        } else {
            // TODO: change code to get info rom new tables:
        }
        return $this->render('stepthree', [
            'model'     => $storeSignupFirstStoreForm
        ]);
    }    
    
    
}
