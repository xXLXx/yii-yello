<?php
/**
 * v1-specific restful User controller
 */

namespace api\modules\v1\controllers;


use api\modules\v1\models\LoginForm;
use api\modules\v1\models\PasswordResetRequestForm;
use api\modules\v1\models\SignupForm;
use Yii;
use yii\web\Response;

class UserController extends \api\common\controllers\UserController
{
    protected function verbs()
    {
        return array_merge(parent::verbs(), [
            'reset-password' => ['POST'],
        ]);
    }


    /**
     * Login
     *
     * @internal string $login      User's login
     * @internal string $password   User's password
     *
     * @return string AuthKey or model errors
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return [
                'accessToken' => \Yii::$app->user->identity->accessToken,
            ];
        } else {
            return $model->getErrors();
        }
    }

    /**
     * Register
     *
     * @internal string $login      User's login
     * @internal string $password   User's password
     * @internal string $firstName  User's first name
     * @internal string $lastName   User's last name
     *
     * @return array containing access-token or model errors
     */
    public function actionRegister()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup();
            if ($user) {
                return [
                    'accessToken' => $user->accessToken,
                ];
            } else {
                return $model->getErrors();
            }
        }
        return false;
    }

    /**
     * Make a reset password request
     *
     * @internal string $email User's email address
     *
     * @return Response
     */
    public function actionResetPassword()
    {
        $model = new PasswordResetRequestForm();
        $model->email = Yii::$app->request->post('email');
        $response = Yii::$app->getResponse();
        if ($model->validate() && $model->sendEmail()) {
            $response->setStatusCode(204);
        } else {
            $response->setStatusCode(400);
            $response->data['message'] = $model->getErrors('email');
        }
        return $response;
    }
}