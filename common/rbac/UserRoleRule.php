<?php

namespace common\rbac;

use common\models\Role;
use Yii;
use yii\rbac\Rule;

class UserRoleRule extends Rule
{
    public $name = 'userRole';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->role;

            if ($item->name === $role->name) {
                return true;
            }

            // super powers
            if ($role->name === Role::ROLE_SUPER_ADMIN) {
                return true;
            }

            $managerChildren = [Role::ROLE_EMPLOYEE];
            $storeOwnerChildren = array_merge($managerChildren, [Role::ROLE_MANAGER]);
            $franchiserChildren = [Role::ROLE_FRANCHISER_MANAGER];
            $yelloAdminChildren = array_merge($storeOwnerChildren, $franchiserChildren);

            if ($role->name === Role::ROLE_YELLO_ADMIN && in_array($item->name, $yelloAdminChildren)) {
                return true;
            }

            if ($role->name === Role::ROLE_FRANCHISER && in_array($item->name, $franchiserChildren)) {
                return true;
            }

            if ($role->name === Role::ROLE_STORE_OWNER && in_array($item->name, $storeOwnerChildren)) {
                return true;
            }
        }

        return false;
    }
}