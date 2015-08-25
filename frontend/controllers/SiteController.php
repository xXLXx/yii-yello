<?php
namespace frontend\controllers;

use common\models\User;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;
use yii\web\JsonResponseFormatter;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public $layout = 'bootstrapsimple';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        if (!\Yii::$app->user->isGuest) {
            return \Yii::$app->getResponse()->redirect(['settings/index']);
        }else{
            return \Yii::$app->getResponse()->redirect(['site/login']);
        }
        return $this->render('index');
    }




    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->user->identity->indexUrl);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->user->identity->indexUrl);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }







    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        if (!\Yii::$app->user->isGuest) {
            return \Yii::$app->getResponse()->redirect(['settings/index']);
        }
        $model = new SignupForm();
        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('signup', [
                'model' => $model,
            ]);
        }
        $user = $model->signup();
        if (!$user) {
            return $this->render('signup', [
                'model' => $model,
            ]);
        }
        $email = Yii::$app->mailer->compose()
            ->setTo($user->email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setSubject('Signup Confirmation')
            ->setHtmlBody(
                "Click this link " . Html::a(
                    'Confirm',
                    Yii::$app->urlManager->createAbsoluteUrl(
                        [
                            'site/confirm',
                            'id'  => $user->id,
                            'key' => $user->authKey
                        ]
                    ),
                    ['target' => '_blank']
                )
            )
            ->send();
        if ($email) {
            Yii::$app->getSession()->setFlash('success','Please verify your email address. Email with instructions to activate your account was sent, check your email.');
        }
        else {
            Yii::$app->getSession()->setFlash('success','Failed, contact admin.');
        }
        return Yii::$app->getResponse()->redirect(
            ['site/verification']
        );
    }

    public function actionVerification()
    {
        return $this->render('verification');
    }

    public function actionResendVerificationLink($user_email){

        $loginForm = new LoginForm();
        $loginForm->email = $user_email;

        $user = $loginForm->getInActiveUser();
        if(!$user){
            return Yii::$app->getResponse()->redirect(
                ['site/login']
            );
        }

        $email = Yii::$app->mailer->compose()
            ->setTo($user->email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setSubject('Signup Confirmation')
            ->setHtmlBody(
                "Click this link " . Html::a(
                    'Confirm',
                    Yii::$app->urlManager->createAbsoluteUrl(
                        [
                            'site/confirm',
                            'id'  => $user->id,
                            'key' => $user->authKey
                        ]
                    ),
                    ['target' => '_blank']
                )
            )
            ->send();
        if ($email) {
            Yii::$app->getSession()->setFlash('success','Please verify your email address. Email with instructions to activate your account was sent, check your email.');
        }
        else {
            Yii::$app->getSession()->setFlash('success','Failed, contact admin.');
        }
        return Yii::$app->getResponse()->redirect(
            ['site/verification']
        );

    }

    public function actionActivation()
    {
        return $this->render('activation');
    }

    public function actionConfirm($id, $key)
    {
        // sign the user out first
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }
        
        
        $user = User::find()->where([
            'id' => $id,
            'authKey' => $key,
            'active' => 0,
        ])->one();
        if(!empty($user)){
            $user->active = 1;
            $user->save();
            Yii::$app->getSession()->setFlash('success','Account is successfully activated. Now you can sign in.');
        }
        else{
            Yii::$app->getSession()->setFlash('success','Failed!');
        }
        return Yii::$app->getResponse()->redirect(
            ['site/activation']
        );
    }

    public function actionRequestPasswordReset()
    {
        $request = Yii::$app->request;
        $model = new PasswordResetRequestForm();
        if ($request->isAjax) {
            $response = new Response();
            $response->format = Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                if ($model->sendEmail()) {
//                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
                    $response->data = [
                        'status' => 'ok'
                    ];
                } else {
                    $response->data = [
                        'status' => 'error',
                        'message' => 'Sorry, we are unable to reset password for email provided.'
                    ];
                    Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
                }
            } else {
                $response->data = [
                    'status' => 'error',
                    'message' => $model->errors
                ];
            }
//            (new JsonResponseFormatter())->format($response);
            return $response;
        }


        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionTermsConditions(){

        if(Yii::$app->request->isAjax){
            $this->layout = false;
        }

        return $this->render('terms-conditions');
    }
}
