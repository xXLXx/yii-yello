<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use common\helpers\EmailHelper;
use yii\helpers\Html;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['active' => true],
                'message' => 'Couldn\'t find an account for this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'active' => true,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->passwordResetToken)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {

                $link = \Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->passwordResetToken]);

                $sent = EmailHelper::sendEmail('reset-password',
                    [
                        'email' => $this->email,
                        'name' => $user->username,
                    ],
                    [
                        'FNAME' => $user->username,
                        'SUBJECT' => 'Password reset for ' . \Yii::$app->name,
                        'PWRESETLK' => Html::a('Reset Your Password', $link),
                        'PWRESETLK_LONG' => Html::a($link,$link)
                    ]);
                return $sent;


            }
        }

        return false;
    }
}
