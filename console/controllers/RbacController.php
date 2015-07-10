<?php

namespace console\controllers;

use common\rbac\UserRoleRule;
use Yii;
use yii\console\Controller;
use common\models\Role;
use yii\helpers\ArrayHelper;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        $rule = new UserRoleRule();
        $auth->add($rule);
        $roles = Role::find()->all();
        $roleNames = ArrayHelper::getColumn($roles, 'name');
        foreach ($roleNames as $roleName) {
            $role = $auth->createRole($roleName);
            $role->description = $roleName;
            $role->ruleName = $rule->name;
            $auth->add($role);
        }
    }
}