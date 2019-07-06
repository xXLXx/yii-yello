<?php

namespace frontend\controllers;

use common\models\User;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * User controller
 *
 * @author markov
 */
class UserController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['edit'],
                'rules' => [
                    [
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }
    
    /**
     * Edit user
     */
    public function actionEdit($userId)
    {
        $this->checkNotSelf($userId);
        $user = User::findOne($userId);

        if (!$user) {
            throw new NotFoundHttpException;
        }

        return $this->render('edit', [
            'user'      => $user
        ]);
    }
    
    /**
     * Delete user
     */
    public function actionDelete($userId)
    {
        /** @var User $user */
        $user = User::findOne($userId);
        if ($user) {
            $user->delete();
            if (\Yii::$app->user->id == $userId) {
                \Yii::$app->user->logout();
            }
        } else {
            throw new NotFoundHttpException;
        }
        return $this->goBack(\Yii::$app->user->getReturnUrl());
    }

    private function checkNotSelf($userId)
    {
        $userId = (int) $userId;
        if ($userId == \Yii::$app->user->identity->id) {
            throw new ForbiddenHttpException;
        }
    }
}
