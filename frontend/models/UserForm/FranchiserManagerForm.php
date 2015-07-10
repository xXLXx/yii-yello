<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 25.06.2015
 * Time: 11:34
 */

namespace frontend\models\UserForm;


use common\models\Role;
use common\models\User;

class FranchiserManagerForm extends CommonManagerForm
{
    protected function setIsAdminDependentRole(User $user)
    {
        if ($this->isAdmin) {
            $role = Role::findOne(['name' => Role::ROLE_FRANCHISER_MANAGER_EXTENDED]);
        } else {
            $role = Role::findOne(['name' => Role::ROLE_FRANCHISER_MANAGER]);
        }
        $user->roleId = $role->id;
    }

    public function setData($user)
    {
        parent::setData($user);
        switch ($user->role->name) {
            case Role::ROLE_FRANCHISER_MANAGER_EXTENDED:
                $this->isAdmin = true;
                break;
            case Role::ROLE_FRANCHISER_MANAGER:
                $this->isAdmin = false;
                break;
        }
        $this->roleId = Role::findOne(['name' => Role::ROLE_FRANCHISER_MANAGER])->id;
    }


}