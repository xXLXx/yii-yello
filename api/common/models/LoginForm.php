<?php
/**
 * Restful LoginForm model
 */

namespace api\common\models;
use yii\web\UnauthorizedHttpException;

use \Yii;

class LoginForm extends \common\models\LoginForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [
                ['email'], 'required',
                'message' => \Yii::t('app', 'Please enter your email address.')
            ],
            [
                ['password'], 'required',
                'message' => \Yii::t('app', 'Please enter your password.')
            ],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        $this->setAttributes($data);
        return true;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
                if($user->roleId!=3){
                  \Yii::$app->user->logout();
                    throw new UnauthorizedHttpException('You are requesting with an invalid credential.');
                    return false;
                }
            if (empty($user->accessToken)) {
                $user->generateAccessToken();
                $user->save();
            }
            return Yii::$app->user->login($this->getUser());
        } else {
            return false;
        }
    }
}