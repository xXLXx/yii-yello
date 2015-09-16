<?php

namespace frontend\controllers;

use common\helpers\ArrayHelper;
use common\helpers\TimezoneHelper;
use common\models\Role;
use common\models\Store;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use common\models\Shift;
use common\services\ShiftCalendarService;
use yii\web\Response;
use common\helpers\EventNotificationsHelper;

/**
 * Shifts calendar controller
 *
 * @author markov
 */
class ShiftsCalendarController extends BaseController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                            [
                                'actions' => ['shiftAdd', 'shiftEdit', 'shiftDelete'],
                                'allow' => true,
                                'roles' => [Role::ROLE_STORE_OWNER]
                            ],
                        ],
                    ],
        ]);
    }

    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }    
    
    /**
     * Index page
     */
    public function actionIndex() {
        
        $user = Yii::$app->user->identity;
        $storeOwner = $user->storeOwner;
        return $this->render('index', [
                    'mode' => null,
                    'shiftId' => 0,
                    'store' => $user->storeCurrent
        ]);
    }

    /**
     * Shift add
     */
    public function actionShiftAdd() {
        $user = Yii::$app->user->identity;
        $storeOwner = $user->myStoreOwner;


        if (Yii::$app->request->getHeaders()->has('X-PJAX')) {
            return $this->renderAjax('index', [
                        'mode' => 'shiftForm',
                        'shiftId' => 0,                       
                'store' => $user->storeCurrent

            ]);
        } else {
            return $this->render('index', [
                        'mode' => 'shiftForm',
                        'shiftId' => 0,
                        'store' => $user->storeCurrent
            ]);
        }
    }

    /**
     * Shift edit
     */
    public function actionShiftEdit($shiftId) {
        $user = Yii::$app->user->identity;
        $storeOwner = $user->myStoreOwner;
        if (Yii::$app->request->getHeaders()->has('X-PJAX')) {
            return $this->renderAjax('index', [
                        'mode' => 'shiftForm',
                        'shiftId' => $shiftId,
                        'store' => $user->storeCurrent
            ]);
        } else {
            return $this->render('index', [
                        'mode' => 'shiftForm',
                        'shiftId' => $shiftId,
                        'store' => $user->storeCurrent
            ]);
        }
    }

    /**
     * Shift delete
     *
     * @param int $shiftId
     *
     * @return \yii\web\Response
     */
    public function actionShiftDelete($shiftId) {
        $shift = Shift::findOne($shiftId);
        if ($shift) {
            $shift->delete();
            
            EventNotificationsHelper::cancelShift($shift->shiftHasAcceptedDriver->driverId, $shift->id);
        }

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'status' => 'ok'
        ];
    }

    /**
     * Shift view
     */
    public function actionShiftView($shiftId) {
        $user = Yii::$app->user->identity;
        $storeOwner = $user->myStoreOwner;

        if (Yii::$app->request->getHeaders()->has('X-PJAX')) {
            return $this->renderAjax('index', [
                        'mode' => 'shiftView',
                        'shiftId' => $shiftId,
                        'store' => $user->storeCurrent
            ]);
        } else {
            $shift = Shift::findOne($shiftId);
                if (!$shift) {
                    return \Yii::$app->getResponse()->redirect(['shifts-calendar/index']);
                }else{
                    return $this->render('index', [
                                'mode' => 'shiftView',
                                'shiftId' => $shiftId,
                                'store' => $user->storeCurrent
                    ]);
                    
                }
            
        }
    }

    /**
     * Events
     */
    public function actionGetEvents() {

        $request = \Yii::$app->getRequest();
        $start = $request->post('start');
        $end = $request->post('end');
        $storeId = $request->post('storeId');
        $shiftId = $request->post('shiftId');
        // start/end are expected to be in local timezone
        // and should be from midnight tomidnight end date
        $timezone = Store::findOne($storeId)->timezone;
        $start = new \DateTime($start, new \DateTimeZone($timezone));
        $start = TimezoneHelper::convertToUTC($timezone, $start);
        $end = new \DateTime($end, new \DateTimeZone($timezone));
        $end = TimezoneHelper::convertToUTC($timezone, $end);

        $events = ShiftCalendarService::getEvents(compact('start', 'end', 'storeId', 'timezone'));
        $unconfirmedShifts = Shift::find()->byStore($storeId)->unconfirmed()->within($start->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s'))->all();

        return Json::encode(compact('events', 'shiftId', 'unconfirmedShifts'));
    }

}
