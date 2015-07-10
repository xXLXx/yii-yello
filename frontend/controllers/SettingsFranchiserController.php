<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 24.06.2015
 * Time: 18:05
 */

namespace frontend\controllers;


use common\helpers\ArrayHelper;
use common\models\Role;
use common\models\search\InvitationSearch;
use common\models\User;
use frontend\models\Exception\FranchiserUndefinedException;
use Yii;
use yii\filters\AccessControl;

class SettingsFranchiserController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['users', 'invitations'],
                'rules' => [
                    [
                        'actions' => ['users', 'invitations'],
                        'allow' => true,
                        'roles' => [Role::ROLE_FRANCHISER, Role::ROLE_FRANCHISER_MANAGER_EXTENDED]
                    ],
                    [
                        'actions' => ['users', 'invitations'],
                        'allow' => false,
                        'roles' => ['@'],
                    ],

                ],
            ],
        ];
    }

    /**
     * Display list of invitations
     *
     * @return string
     */
    public function actionInvitations()
    {
        $searchParams = Yii::$app->request->getQueryParams();
        $searchModel = new InvitationSearch();
        $dataProvider = $searchModel->search($searchParams);

        return $this->render('invitations', [
            'dataProvider' => $dataProvider,
            'searchParams' => $searchParams
        ]);
    }

    /**
     * Display list of user created
     *
     * @return array
     */
    public function actionUsers()
    {
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        $roleGroups = [
            'manager' => [
                'title' => 'Manager Staff',
                'roles' => [
                    Role::ROLE_FRANCHISER_MANAGER,
                    Role::ROLE_FRANCHISER_MANAGER_EXTENDED
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
            'name' => [Role::ROLE_FRANCHISER_MANAGER]
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
            ->andWhere('id != ' . Yii::$app->user->identity->id)
            ->all();
        return $users;
    }

    /**
     * @return User
     * @throws FranchiserUndefinedException
     */
    private function getUsersOwner()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if ($user->franchiser) {
            return $user;
        } else {
            if ($user->parentUser && $user->parentUser->franchiser) {
                return $user->parentUser;
            }
        }

        throw new FranchiserUndefinedException($user);
    }
}