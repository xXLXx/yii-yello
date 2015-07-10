<?php
/**
 * Basic controller for another ActiveControllers
 */

namespace api\common\controllers;


use api\common\models\Driver;
use yii\db\ActiveRecord;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

abstract class BaseActiveController extends ActiveController
{
    /**
     * @inheritdoc
     */
    public $serializer = [
        'class' => 'api\modules\v1\components\Serializer',
        'collectionEnvelope' => 'items',
        'errorEnvelope' => 'error',
        'messageEnvelope' => 'message',
        'modelEnvelope' => 'item',
    ];

    /**
     * Find a shift with the specified ID
     *
     * @param integer $id ID of the shift we are trying to find
     * @return ActiveRecord Shift model with the specified ID if it exists
     * @throws NotFoundHttpException If the specified shift does no exist
     */
    public function findModel($id)
    {
        /** @var ActiveRecord $class */
        $class = $this->modelClass;
        $model = $class::find()->where(['id' => $id])->one();
        if (!empty($model)) {
            return $model;
        }
        throw new NotFoundHttpException("The specified shift was not found");
    }

    /**
     * Get ID of currently authenticated driver
     *
     * @return int|string
     */
    public function getDriverId()
    {
        $user = Driver::getCurrent();
        return $user->getId();
    }
}