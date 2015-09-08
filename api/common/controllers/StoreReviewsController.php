<?php
/**
 * Restful store controller
 */

namespace api\common\controllers;


use api\modules\v1\filters\Auth;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

class StoreReviewsController extends BaseActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'common\models\Storereviews';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => Auth::className(),
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // Override this, we have our own.
        unset($actions['create']);

        return $actions;
    }

    /**
     * Overrides default implementation to inject current user into driverId
     * of the model class.
     *
     * @inheritdoc
     */
    public function actionCreate()
    {
        /* @var $model \common\models\Storereviews */
        $model = new $this->modelClass();

        $model->driverId = \Yii::$app->user->id;
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }
}