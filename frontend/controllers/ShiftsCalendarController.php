<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Json;
use common\models\Shift;
use common\services\ShiftCalendarService;

/**
 * Shifts calendar controller
 *
 * @author markov
 */
class ShiftsCalendarController extends BaseController
{
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
        $storeOwner = $user->storeOwner;
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
        $storeOwner = $user->storeOwner;
        return $this->render('index', [
            'mode'      => 'shiftForm',
            'shiftId'   => $shiftId,
            'store'     => $storeOwner->storeCurrent
        ]);
    }

    /**
     * Shift view
     */
    public function actionShiftView($shiftId)
    {
        $user = Yii::$app->user->identity;
        $storeOwner = $user->storeOwner;
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
        $post = Yii::$app->request->post();
        $events = ShiftCalendarService::getEvents([
            'start'     => $post['start'],
            'end'       => $post['end'],
            'storeId'   => $post['storeId']
        ]);
        return Json::encode([
            'events' => $events
        ]);
    }
}
