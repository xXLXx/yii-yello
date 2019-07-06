<?php
/**
 * Password change form
 */

namespace common\models;


use yii\base\Model;

class PasswordChangeForm extends Model
{
    /**
     * Old password
     *
     * @var string
     */
    public $oldPassword;

    /**
     * New password
     *
     * @var string
     */
    public $newPassword;

    /**
     * Password confirmation
     *
     * @var string
     */
    public $confirmPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'oldPassword',
                    'newPassword',
                    'confirmPassword',
                ],
                'required',
            ],
            [
                [
                    'newPassword',
                    'confirmPassword',
                ],
                'string',
                'min' => 6,
            ],
            [
                [
                    'oldPassword',
                ],
                'validateOldPassword',
                'message' => 'Entered old password is not correct',

            ],
            [
                [
                    'confirmPassword',
                ],
                'compare',
                'compareAttribute' => 'newPassword',
            ]
        ];
    }

    /**
     * Save a new password
     *
     * @return bool
     */
    public function save()
    {
        /** @var User $user */
        $user = \Yii::$app->user->getIdentity();
        if (empty($user)) {
            return false;
        }
        $user->setPassword($this->newPassword);
        $user->save();
        return true;
    }

    /**
     * Validate old password entered by user
     *
     * @return bool
     */
    public function validateOldPassword()
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }
        /** @var User $user */
        $user = \Yii::$app->user->getIdentity();
        if (empty($user)) {
            return false;
        }
        if (!$user->validatePassword($this->oldPassword)) {
            $this->addError('oldPassword', 'Entered old password is not correct');
            return false;
        }
        return true;
    }
}