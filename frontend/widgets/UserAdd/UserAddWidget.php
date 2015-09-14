<?php

namespace frontend\widgets\UserAdd;

use common\models\Role;
use common\models\User;
use frontend\models\UserForm\UserAddForm;
use Yii;
use yii\helpers\Html;
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

                $user = User::find()->where(['id' => $model->id])->one();
                $user->generatePasswordResetToken();
                $user->save();

                $email = Yii::$app->mailer->compose()
                    ->setTo($model->email)
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                    ->setSubject('Welcome to Yello')
                    ->setHtmlBody(
                        "Welcome to your new Yello account. Click this link " . Html::a(
                            'Login',
                            Yii::$app->urlManager->createAbsoluteUrl(
                                [
                                    'site/reset-password',
                                    'id'  => $model->id,
                                    'token' => $user->passwordResetToken
                                ]
                            ),
                            ['target' => '_blank']
                        )
                    )
                    ->send();


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
