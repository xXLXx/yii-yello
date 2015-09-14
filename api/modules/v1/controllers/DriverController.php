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
use api\modules\v1\models\ShiftState;
use yii\data\ActiveDataProvider;
use common\models\ShiftReviews;

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

    public function actions()
    {
        $actions = parent::actions();

        // disable the "index", "delete" and "create" actions
        unset($actions['delete'], $actions['create'], $actions['index'], $actions['view']);

        return $actions;
    }
    
    
    
    
    
    /**
     * @inheritdoc
     */
    public function actionPersonalInfo()
    {
        $model = new DriverForm();
        $post = \Yii::$app->request->post();

        /*file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.'HERE IS THE PERSONAL INFO CONTROLLER' . PHP_EOL, FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export('postPersonal' . PHP_EOL, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export('Files' . PHP_EOL, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export($_FILES, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export('Info' . PHP_EOL, true), FILE_APPEND);
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.'now the post...' . PHP_EOL, FILE_APPEND);
        
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export($post, true), FILE_APPEND);*/
        if ($model->load($post)) {
            if ($model->savePersonalInfo()) {
                //file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'Save Successful' . PHP_EOL, FILE_APPEND);
                return Driver::getCurrent();
            }else{
                //file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'WE HAD ERRORS with personal info save' . PHP_EOL, FILE_APPEND);
                $err = $model->getErrors() ? $model->getErrors() : 'unknown';
                //file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', PHP_EOL.var_export($err . PHP_EOL, true) . PHP_EOL, FILE_APPEND);
                $response = \Yii::$app->getResponse();
                $response->setStatusCode(400);
                $output = [];
                $output['message'] = $model->getErrors();
                return $output;

            }
        } else {
                //file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'WE HAD No Post Data' . PHP_EOL, FILE_APPEND);
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
                return $model;
            }else{
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'Vehicle model didnt validate' . PHP_EOL, FILE_APPEND);
            }
        }

        $response = \Yii::$app->getResponse();
        $response->setStatusCode(400);
        $output = [];
        $output['message'] = $model->getErrors();
        return $output;
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
                return $model;
            }else{
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'workdetails model didnt validate' . PHP_EOL, FILE_APPEND);
            }
        }else{
                file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', 'workdetails model didnt load post'. PHP_EOL, FILE_APPEND);
                
       }
        $response = \Yii::$app->getResponse();
        $response->setStatusCode(400);
        $output = [];
        $output['message'] = $model->getErrors();
        return $output;
//        return $model->getErrors() ? $model->getErrors() : $model;
    }
    
    public function actionMyReviews(){
        //As we want to add another meta to activeDataProvider, The serializer should be merged.

        $this->serializer = \yii\helpers\ArrayHelper::merge($this->serializer, [
            'class' => 'api\modules\v1\components\MyReviewSerializer',
        ]);

        $me = \Yii::$app->user->identity->id;
        $query = ShiftReviews::find()->where(['driverId'=>$me,'ShiftReviews.isArchived'=>0])->orderBy(['createdAt'=>SORT_DESC])
        ->joinWith(['store']);
        return new ActiveDataProvider([
            'query' => $query,

        ]);
    }
    
    
    
    public function actionAccreditation(){
        $post = \Yii::$app->request->post();
        $msg='unknown';
        if($post['success']=='1'){
             $user = \Yii::$app->user->identity;
             $step = $user->signup_step_completed;
             if($step>2){
                $user->signup_step_completed=10;
                $user->save();
                $msg='success';
                $response = \Yii::$app->getResponse();
                $response->setStatusCode(200);
                $output = [];
                $output['message'] = $msg;
                return $output;
             }else{
                    $response = \Yii::$app->getResponse();
                    $response->setStatusCode(400);
                    $output = [];
                    $output['message'] = 'Driver profile incomplete';
                    return $output;
             }
        }
        $response = \Yii::$app->getResponse();
        $response->setStatusCode(400);
        $output = [];
        $output['message'] = 'Accreditation Failure';
        return $output;
        
    }    
    
    /**
     * Gets all drivers with active shifts limited from 24 hours ago to now
     */
    public function actionActive()
    {
        $storeId = \Yii::$app->request->get('storeid');

        $shiftState = ShiftState::findOne(['name' => ShiftState::STATE_ACTIVE]);
        
        return new ActiveDataProvider([
            'query' => Driver::find()
                ->innerJoinWith(['acceptedShifts'])
                ->andWhere([
                    'storeId'       => $storeId,
                    'shiftStateId'  => $shiftState->id
                ])
                ->andWhere(['>=', 'end', date('Y-m-d H:i:s', strtotime('-24 hours'))]),
            'pagination' => false
        ]);
    }
}