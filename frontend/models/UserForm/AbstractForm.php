<?php

namespace frontend\models\UserForm;

use common\models\User;

/**
 * User form
 */
abstract class AbstractForm extends \yii\base\Model
{
    /**
     * Save
     */
    abstract public function save();
 
    /**
     * Get template
     * 
     * @return string
     */
    abstract public function getTemplate();
    
    /**
     * Set data from user
     * 
     * @param \common\models\User $user user
     */
    public function setData($user)
    {
        $this->setAttributes($user->getAttributes());
    }
    
    /**
     * Validate Unique email
     * 
     * @param string $attribute
     * @return boolean
     */
    public function validateUniqueEmail($attribute)
    {
        $user = User::findOne(['email' => $this->$attribute]);
        if (!$user) {
            return true;
        }
        if ($user->id == $this->id) {
            return true;
        }
        $this->addError(
            $attribute, \Yii::t('app', 'This email has already been taken.')
        );
        return false;
    }
    
    /**
     * Validate compare confirm
     * 
     * @param string $attribute
     * @return boolean
     */
    public function validateСompareConfirm()
    {
        if (!$this->password) {
            return true;
        }
        if ($this->password == $this->confirm) {
            return true;
        }
        $this->addError(
            'confirm', \Yii::t('app', 'Passwords doesn\'t match.')
        );
        return false;
    }
}
