<?php

namespace console\controllers;
use common\models\User;

/**
 * Manages User.
 */
class UsersController extends \yii\console\Controller
{
    /**
     * Updates a user password.
     * ~~~
     * ./yii users/update-password 123 secret_password_here
     * ~~~
     *
     * @param $userId
     * @param $password
     * 
     * @return int
     */
    public function actionUpdatePassword($userId, $password)
    {
        $user = User::findOne($userId);
        if (!$user) {
            print 'User not found.';
            print PHP_EOL;
            return 1;
        }

        $user->password = $password;
        if (!$user->save()) {
            print 'Something went wrong.' . PHP_EOL;
            return 1;
        }

        print 'Password updated for ' . $user->username . PHP_EOL;
        return 0;
    }
}
