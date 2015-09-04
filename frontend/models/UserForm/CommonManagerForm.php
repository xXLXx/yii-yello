<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 25.06.2015
 * Time: 11:39
 */

namespace frontend\models\UserForm;


use common\models\User;

class CommonManagerForm extends UserForm
{

    public $isAdmin;

    public function rules()
    {
        return array_merge([
            [['isAdmin'], 'boolean'],
        ], parent::rules());
    }

    public function save()
    {
        parent::save();

        $user = User::findOne($this->id);
        if ($user) {
            $this->setIsAdminDependentRole($user);
            $user->save();
        }
    }

    protected function setIsAdminDependentRole(User $user)
    {
        // change admin role if appropriate
            if(\Yii::$app->user->can('AssignUserToStore')){
                
            }
    }

    public function getTemplate()
    {
        return 'user';
    }

}