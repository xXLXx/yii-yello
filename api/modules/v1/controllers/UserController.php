<?php
/**
 * v1-specific restful User controller
 */

namespace api\modules\v1\controllers;


use api\modules\v1\models\LoginForm;
use api\modules\v1\models\PasswordResetRequestForm;
use api\modules\v1\models\SignupForm;
use common\models\DriverHasStore;
use common\models\SignupInvitations;
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
            $response = Yii::$app->getResponse();
            $response->setStatusCode(400);
            $response->data['message'] = $model->getErrors();
            return $response;
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
        $params = Yii::$app->request->post();
        if ($model->load($params)) {
            $user = $model->signup();
            if ($user) {

                if(isset($params['invitationcode'])){

                    $main_invitation = SignupInvitations::find()->where( ['invitationcode' => $params['invitationcode'] ] )->one();

                    if($main_invitation){

                        DriverHasStore::inviteAccepted($user->id, $main_invitation->storeownerfk, 1);

                        $all_invitations = SignupInvitations::find()
                            ->where( ['emailaddress' => $main_invitation->emailaddress ])
                            ->andWhere( ['NOT IN', 'invitationcode', $params['invitationcode']] )
                            ->all();

                        foreach($all_invitations as $invitation){

                            DriverHasStore::inviteAccepted($user->id, $invitation->storeownerfk);

                        }

                    }

                }

                return [
                    'accessToken' => $user->accessToken,
                ];
            } else {
                    $response = Yii::$app->getResponse();
                    $response->setStatusCode(400);
                    $response->data['message'] = $model->getErrors();
                    return $response;
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
            $response->data['message'] = $model->getErrors();
        }
        return $response;
    }
}