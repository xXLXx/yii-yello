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

        if ($model->load($post) && $model->save($user)) {
            return $this->redirect(['step-two']);
        } else {
            $model->loadData($user);
        }

        return $this->render('index', [
            'model'     => $model
        ]);
    }
    
    public function actionStepTwo()
    {
        $user = \Yii::$app->user->identity;
        $post = \Yii::$app->request->post();
        $model = new \frontend\models\SignupStorePaymentDetails([
            'companyId' => $user->company->id,
        ]);
        if ($model->load($post) && $model->save($user)) {
            return $this->redirect(['step-three']);
        }

        return $this->render('steptwo', [
            'model'     => $model
        ]);
    }

    public function actionStepThree()
    {
        $user = \Yii::$app->user->identity;
        $post = \Yii::$app->request->post();
        $companyaddress = $user->companyAddress;
        $model = new \frontend\models\SignupStoreFirstStore([
            'companyId' => $user->company->id,
            'contact_name'=> $companyaddress->contact_name,
            'contact_email'=>$companyaddress->contact_email,
                'contact_phone'=>$companyaddress->contact_phone
        ]);
        if ($model->load($post) && $model->save($user)) {
            return $this->redirect(['settings/index']);
        }

        return $this->render('stepthree', [
            'model' => $model
        ]);
    }    
    
    
}
