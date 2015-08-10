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
        }
        $managerRole = Role::findOne(['name' => Role::ROLE_MANAGER]);
        return $this->render('default', [
            'model' => $model,
            'json' => Json::encode([
                'managerRoleId' => $managerRole->id
            ]),
            'canSetIsAdmin' => \Yii::$app->user->can('PromoteUserAsAdmin'),
        ]);
    }
}
