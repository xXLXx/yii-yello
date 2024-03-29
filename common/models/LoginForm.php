<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    protected $_user = false;


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
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('login', 'Incorrect username or password.');
            }
        }
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
            if ($user && $user->isBlocked) {
                $this->addError('password', 'Your account is blocked. Contact with administration');
                return false;
            }
            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::find()
                ->active()
                ->andWhere(['email'  => $this->email])
                    ->one();
        }

        return $this->_user;
    }
}
