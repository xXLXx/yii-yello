<?php

namespace frontend\controllers;

use common\helpers\ArrayHelper;
use common\models\Role;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use common\models\Shift;
use common\services\ShiftCalendarService;
use yii\web\Response;

/**
 * Shifts calendar controller
 *
 * @author markov
 */
class ShiftsCalendarController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
    /**
     * Index page
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $storeOwner = $user->storeOwner;
        return $this->render('index', [
            'mode'      => null,
            'shiftId'   => 0,
            'store'     => $storeOwner->storeCurrent
        ]);
    }

    /**
     * Shift add
     */
    public function actionShiftAdd()
    {
        $user = Yii::$app->user->identity;
        $storeOwner = $user->myStoreOwner;
        return $this->render('index', [
            'mode'      => 'shiftForm',
            'shiftId'   => 0,
            'store'   => $storeOwner->storeCurrent
            
        ]);
    }


    
    /**
     * Shift edit
     */
    public function actionShiftEdit($shiftId)
    {
        $user = Yii::$app->user->identity;
        $storeOwner = $user->myStoreOwner;
        return $this->render('index', [
            'mode'      => 'shiftForm',
            'shiftId'   => $shiftId,
            'store'     => $storeOwner->storeCurrent
        ]);
    }

    /**
     * Shift delete
     *
     * @param int $shiftId
     *
     * @return \yii\web\Response
     */
    public function actionShiftDelete($shiftId)
    {
        $shift = Shift::findOne($shiftId);
        if ($shift) {
            $shift->delete();
        }

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'status' => 'ok'
        ];
    }

    /**
     * Shift view
     */
    public function actionShiftView($shiftId)
    {
        $user = Yii::$app->user->identity;
        $storeOwner = $user->myStoreOwner;
        return $this->render('index', [
            'mode'      => 'shiftView',
            'shiftId'   => $shiftId,
            'store'     => $storeOwner->storeCurrent
        ]);
    }

    /**
     * Events
     */
    public function actionGetEvents()
    {
        $request = \Yii::$app->getRequest();
        $start = $request->post('start');
        $end = $request->post('end');
        $storeId = $request->post('storeId');
        $shiftId = $request->post('shiftId');
        $events = ShiftCalendarService::getEvents(compact('start', 'end', 'storeId'));
        $unconfirmedShifts = Shift::find()->unconfirmed()->within($start, $end)->all();

        return Json::encode(compact('events', 'shiftId', 'unconfirmedShifts'));
    }
}
