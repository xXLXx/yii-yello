<?php

namespace frontend\widgets\UserAdd;

use common\models\Role;
use common\models\User;
use frontend\models\UserForm\UserAddForm;
use Yii;
use yii\helpers\Json;

/**
 * User add widget
 *
 * @author markov
 */
class UserAddWidget extends \yii\base\Widget
{
    /**
     * Role id
     *
     * @var integer
     */
    public $roleId;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = new UserAddForm();
        $post = \Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->validate()) {
                $model->save();
                return \Yii::$app->response->redirect(['settings/users']);
            }
        } else {
            if ($this->roleId) {
                $model->roleId = $this->roleId;
            }
        }
        $managerRole = Role::findOne(['name' => Role::ROLE_MANAGER]);
        return $this->render('default', [
            'model' => $model,
            'json' => Json::encode([
                'managerRoleId' => $managerRole->id
            ]),
            'canSetIsAdmin' => $this->canUserSetIsAdmin(Yii::$app->user->identity),
        ]);
    }

    /**
     * @param User $user
     * @return bool
     */
    private function canUserSetIsAdmin(User $user)
    {
        return in_array($user->role->name, [
            Role::ROLE_FRANCHISER,
            Role::ROLE_MENU_AGGREGATOR,
            Role::ROLE_STORE_OWNER
        ]);
    }
}
