<?php
/**
 * v1-specific restful Driver controller
 */

namespace api\modules\v1\controllers;
use api\modules\v1\models\VehicleForm;
use api\modules\v1\models\DriverForm;
use api\modules\v1\filters\Auth;
use api\modules\v1\models\WorkDetailsForm;

class DriverController extends \api\common\controllers\DriverController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\modules\v1\models\Driver';

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

    /**
     * @inheritdoc
     */
    public function actionPersonalInfo()
    {
        $model = new DriverForm();
        $post = \Yii::$app->request->post();
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('postPersonal' . PHP_EOL, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('Files' . PHP_EOL, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($_FILES, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('Info' . PHP_EOL, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($post, true), FILE_APPEND);
        if ($model->load($post)) {
            if ($model->validate()) {
                $model->save();
                return $model;
            }else{
                return ['response'=>'did not validate', $model];
            }
        } else {
                return 'post required';
        }

//        return $model;
//        return $model->getErrors() ? $model->getErrors() : $model;
    }

    public function actionVehicleInfo()
    {
        $model = new VehicleForm();
        $post = \Yii::$app->request->post();
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('postVehicle' . PHP_EOL, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($_FILES, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($post, true), FILE_APPEND);
        if ($model->load($post)) {
            if ($model->validate()) {
                $model->save();
            }
        }
        return $model;
//        return $model->getErrors() ? $model->getErrors() : $model;
    }

    public function actionWorkDetails()
    {
        $model = new WorkDetailsForm();
        $post = \Yii::$app->request->post();
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('postWorkDetails' . PHP_EOL, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($_FILES, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($post, true), FILE_APPEND);
        if ($model->load($post)) {
            if ($model->validate()) {
                $model->save();
            }
        }
        return $model;
//        return $model->getErrors() ? $model->getErrors() : $model;
    }
}