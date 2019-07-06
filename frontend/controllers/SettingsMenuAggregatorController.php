<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 25.06.2015
 * Time: 15:43
 */

namespace frontend\controllers;


use common\helpers\ArrayHelper;
use common\models\Role;
use common\models\User;
use frontend\models\Exception\MenuAggregatorUndefinedException;
use yii\filters\AccessControl;

class SettingsMenuAggregatorController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(),  [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['users'],
                'rules' => [
                    [
                        'actions' => ['users'],
                        'allow' => true,
                        'roles' => [Role::ROLE_MENU_AGGREGATOR, Role::ROLE_MA_MANAGER_EXTENDED]
                    ],
                    [
                        'actions' => ['users'],
                        'allow' => false,
                        'roles' => ['@'],
                    ],

                ],
            ],
        ]);
    }

    /**
     * Display list of user created
     *
     * @return array
     */
    public function actionUsers()
    {
        \Yii::$app->user->setReturnUrl(\Yii::$app->request->url);
        $roleGroups = [
            'manager' => [
                'title' => 'Manager Staff',
                'roles' => [
                    Role::ROLE_MA_MANAGER,
                    Role::ROLE_MA_MANAGER_EXTENDED,
                ]
            ]
        ];
        $userGroups = [];
        foreach ($roleGroups as $key => $group) {
            $roles = Role::findAll(['name' => $group['roles']]);
            $roleIds = ArrayHelper::getColumn($roles, 'id');
            $userGroups[$key]['title'] = $group['title'];
            $userGroups[$key]['users'] = $this->getUsersToManage(['roleId' => $roleIds]);
        }
        $rolesAdd = Role::findAll([
            'name' => [Role::ROLE_MA_MANAGER]
        ]);
        return $this->render('users', [
            'userGroups' => $userGroups,
            'rolesAdd' => $rolesAdd
        ]);
    }

    /**
     * @param array $condition
     * @return array|\common\models\User[]
     */
    private function getUsersToManage(array $condition)
    {
        /** @var User $user */
        $user = $this->getUsersOwner();
        $users = User::find()
            ->andWhere($condition)
            ->andWhere(['parentId' => $user->id])
            ->all();
        return $users;
    }

    /**
     * @return User
     */
    private function getUsersOwner()
    {
        /** @var User $user */
        $user = \Yii::$app->user->identity;
        if ($user->menuAggregator) {
            return $user;
        } else {
            if ($user->parentUser->menuAggregator) {
                return $user->parentUser;
            }
        }

        throw new MenuAggregatorUndefinedException($user);
    }
}