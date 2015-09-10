<?php

/**
 * Created by PhpStorm.
 * User: alireza
 * Date: 10/09/15
 * Time: 2:55 PM
 */
namespace common\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class EmailChangeForm extends Model
{
    public $email;

    /**
     * @var \common\models\User
     */

    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className()]
        ];
    }

    public function init()
    {
        parent::init();

        $user_id = Yii::$app->user->getId();

        $user = User::findOne([
            'id' => $user_id
        ]);
        $this->_user = $user;
    }


    public function changeEmail()
    {
        if($this->validate())
        {
            if(!empty($this->_user) && $this->_user->setEmail($this->email))
            {
                return true;
            }
        }
        return false;
    }

}
