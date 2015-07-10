<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 25.06.2015
 * Time: 10:53
 */

namespace frontend\widgets\UserAdd;


use common\models\Role;
use frontend\models\Exception\FranchiserUndefinedException;
use frontend\models\UserForm\FranchiserManagerAddForm;
use Psr\Log\LogLevel;
use Yii;
use yii\helpers\Json;

class FranchiserManagerWidget extends UserAddWidget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = new FranchiserManagerAddForm();
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            try {
                $model->save();
                return Yii::$app->response->redirect(['settings-franchiser/users']);
            } catch (FranchiserUndefinedException $e) {
                $model->addError('firstName', sprintf('Cannot detect franchiser for %s', $e->getUser()->username));
                Yii::getLogger()->log($e->getMessage(), LogLevel::ERROR);
            }


        } else {
            if ($this->roleId) {
                $model->roleId = $this->roleId;
            }
        }
        $managerRole = Role::findOne(['name' => Role::ROLE_FRANCHISER_MANAGER]);
        return $this->render('franchiser', [
            'model' => $model,
            'json' => Json::encode([
                'managerRoleId' => $managerRole->id
            ])
        ]);
    }
}