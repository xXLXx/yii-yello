<?php

namespace frontend\widgets\UserEdit;

use common\models\Role;
use common\models\User;
use common\services\UserFormService;
use Yii;
use yii\base\Widget;

/**
 * User edit widget
 *
 * @author markov
 */
class UserEditWidget extends Widget
{
    /**
     * User
     *
     * @var \common\models\User
     */
    public $user;

    /**
     * Page name
     *
     * @var string
     */
    public $pageName;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $roleName = $this->user->role->name;
        $model = UserFormService::getForm($roleName);
        $post = Yii::$app->request->post();
        if (isset($post[$model->formName()])) {
            $loaded = $model->load($post);
            if ($loaded && $model->validate()) {
                $model->save();
                
                 return Yii::$app->getResponse()->redirect(
                        ['settings/users']
                    );
            }
        } else {
            $model->setData($this->user);
        }
        return $this->render('default', [
            'user' => $this->user,
            'model' => $model,
            'pageName' => $this->pageName,
            'canSetIsAdmin' => \Yii::$app->user->can('PromoteUserAsAdmin')
            //'canSetIsAdmin' => $this->canUserSetIsAdmin(Yii::$app->user->identity),
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
