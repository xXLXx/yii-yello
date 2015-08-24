<?php
/**
 * v1-specific restful Driver controller
 */

namespace api\modules\v1\controllers;
use api\modules\v1\models\Driver;
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
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.'HERE IS THE PERSONAL INFO CONTROLLER' . PHP_EOL, FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export('postPersonal' . PHP_EOL, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export('Files' . PHP_EOL, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export($_FILES, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export('Info' . PHP_EOL, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.'now the post...' . PHP_EOL, FILE_APPEND);
        
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export($post, true), FILE_APPEND);
        if ($model->load($post)) {
            if ($model->savePersonalInfo()) {
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'Save Successful' . PHP_EOL, FILE_APPEND);
                return Driver::getCurrent();
            }else{
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'WE HAD ERRORS with personal info save' . PHP_EOL, FILE_APPEND);
                $err = $model->getErrors() ? $model->getErrors() : 'unknown';
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export($err . PHP_EOL, true) . PHP_EOL, FILE_APPEND);
                return $model->getErrors() ? $model->getErrors() : $model;
                return ['response'=>'did not validate', $model];
            }
        } else {
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'WE HAD No Post Data' . PHP_EOL, FILE_APPEND);
                return 'post required';
        }

//        return $model;
//        return $model->getErrors() ? $model->getErrors() : $model;
    }

    public function actionVehicleInfo()
    {
        $model = new VehicleForm();
        $post = \Yii::$app->request->post();
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL. 'Here is the vehicle info controller' . PHP_EOL, FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt',  PHP_EOL.var_export($_FILES, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt',  PHP_EOL.var_export($post, true), FILE_APPEND);
        if ($model->load($post)) {
            if ($model->validate()) {
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'Save Successful' . PHP_EOL, FILE_APPEND);
                $model->save();
            }else{
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'Vehicle model didnt validate' . PHP_EOL, FILE_APPEND);
            }
        }

        return $model;
//        return $model->getErrors() ? $model->getErrors() : $model;
    }

    public function actionWorkDetails()
    {
        $model = new WorkDetailsForm();
        $post = \Yii::$app->request->post();
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'Here is the work detail controller' . PHP_EOL, FILE_APPEND);
       // file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($_FILES, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($post, true), FILE_APPEND);
        if ($model->load($post)) {
            if ($model->validate()) {
                $model->save();
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'Save Successful' . PHP_EOL, FILE_APPEND);
            }else{
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'workdetails model didnt validate' . PHP_EOL, FILE_APPEND);
            }
        }else{
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'workdetails model didnt load post'. PHP_EOL, FILE_APPEND);
                
       }
        return $model;
//        return $model->getErrors() ? $model->getErrors() : $model;
    }
}