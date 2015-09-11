<?php
/**
 * Restful store controller
 */

namespace api\common\controllers;


use api\modules\v1\filters\Auth;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

class StoreReviewsController extends BaseActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'common\models\Storereviews';

    public function init()
    {
        parent::init();

        $this->serializer = \yii\helpers\ArrayHelper::merge($this->serializer, [
            'class' => 'api\modules\v1\components\StoreReviewsSerializer',
        ]);
    }


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

        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

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
        if (!$model->save()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

    /**
     * Overrides default implementation to customized filtering of records.
     *
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        /* @var $modelClass \common\models\Storereviews */
        $modelClass = $this->modelClass;
        $query = $modelClass::find();
        $storeId = \Yii::$app->getRequest()->get('storeId');

        if ($storeId) {
            $query->where(['storeId' => $storeId]);
        } else {
            $query->where(['driverId' => \Yii::$app->user->id]);
        }

        $query->orderBy(['createdAt' => SORT_DESC]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}
