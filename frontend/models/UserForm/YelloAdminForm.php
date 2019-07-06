<?php

namespace frontend\models\UserForm;

use common\models\Image;
use common\models\Role;
use common\models\User;
use yii\web\UploadedFile;
/**
 * YelloAdmin form
 */
class YelloAdminForm extends StoresAwareUserForm
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
        if ( $user ) {

            if ($this->isAdmin) {
                $role = Role::findOne(['name' => Role::ROLE_YELLO_ADMIN]);
                $user->roleId = $role->id;
            } else {
                $role = Role::findOne(['name' => Role::ROLE_MANAGER]);
                $user->roleId = $role->id;
            }

            $user->save();
        }
    }

    public function setData($user)
    {
        parent::setData($user);
        if ($user->role->name === Role::ROLE_YELLO_ADMIN) {
            $this->isAdmin = true;
            $role = Role::findOne(['name' => Role::ROLE_YELLO_ADMIN]);
            $this->roleId = $role->id;
        }

    }

}
