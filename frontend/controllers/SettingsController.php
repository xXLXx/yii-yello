<?php
namespace frontend\controllers;

use common\helpers\ArrayHelper;
use common\helpers\EmailHelper;
use common\models\Role;
use common\models\User;
use frontend\models\Exception\UserStoreOwnerUndefinedException;
use Yii;
use yii\filters\AccessControl;

/**
 * Profile controller
 */
class SettingsController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'users', 'invoices', 'bank', 'schedules', 'yello','test'],
                'rules' => [
                    [
                        'actions' => ['users', 'invoices', 'bank', 'schedules', 'yello'],
                        'allow' => false,
                        'roles' => [Role::ROLE_EMPLOYEE]
                    ],
                    [
                        'actions' => ['users'],
                        'allow' => false,
                        'roles' => [Role::ROLE_MANAGER]
                    ],
                    [
                        'actions' => ['index', 'users', 'invoices', 'bank', 'schedules', 'yello'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionTest(){
        $to='anorouzi69@gmail.com';
        $template= 'adding-user-to-a-store';

        if(isset($_GET['to'])){
            $to=$_GET['to'];
        }
        
        if(isset($_GET['template'])){
            $tempate=$_GET['template'];
        }

        $sent = EmailHelper::sendEmail($template,
            [
                'email' => $to,
                'name' => 'Alireza'
            ],
            [
            'FNAME' => 'Alireza',
            'STNAME' => 'YelloStore',
            'PWRESETLK' => Yii::$app->urlManager->createAbsoluteUrl('site/index')
        ]);


        if($sent){
            return  $this->render('test');
        }else{
            var_dump($sent);
        }

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
                'title' => 'Admin Users',
                'roles' => [
                    'storeOwner',
                    'manager',
                    'yelloAdmin'
                ]
            ],
            'employee' => [
                'title' => 'Users',
                'roles' => [
                    'employee'
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
            'name' => [Role::ROLE_MANAGER, Role::ROLE_EMPLOYEE, Role::ROLE_STORE_OWNER]
        ]);
        return $this->render('users', [
            'userGroups' => $userGroups,
            'rolesAdd' => $rolesAdd
        ]);
    }

    public function actionCompany()
    {
        return $this->render('index');
    }

    /**
     * @param array $condition
     * @return array|User[]
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
     */
    private function getUsersOwner()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if ($user->storeOwner) {
            return $user;
        } else {
            if ($user->parentUser && $user->parentUser->storeOwner) {
                return $user->parentUser;
            }
        }

        throw new UserStoreOwnerUndefinedException($user);
    }
}