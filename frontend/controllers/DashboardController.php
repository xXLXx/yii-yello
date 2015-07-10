<?php

namespace frontend\controllers;
use common\models\ShiftState;
use common\models\Shift;
use common\models\Driver;
use common\models\StoreOwnerFavouriteDrivers;
use common\models\DriverHasStore;

/**
 * Dashboard page controller
 *
 * @author alex
 */
class DashboardController extends BaseController
{
    /**
     * Dashboard page
     */
    public function actionIndex()
    {
        $shifts = Shift::find()->all();
        $completedShiftState = ShiftState::findOne(['name' => ShiftState::STATE_COMPLETED]);
        $pendingShiftState = ShiftState::findOne(['name' => ShiftState::STATE_PENDING]);
        $yelloAllocatedShiftState = ShiftState::findOne(['name' => ShiftState::STATE_YELLO_ALLOCATED]);
        $allocatedState = ShiftState::findOne(['name' => ShiftState::STATE_ALLOCATED]);
        $completedShifts = Shift::findAll(['shiftStateId' => $completedShiftState->id]);
        $pendingShifts = Shift::findAll(['shiftStateId' => $pendingShiftState->id]);
        $yelloAllocatedShifts = Shift::findAll(['shiftStateId' => $yelloAllocatedShiftState->id]);
        $allocatedShifts = Shift::findAll(['shiftStateId' => $allocatedState->id]);
        $shiftItems = [
            [
                'title' => 'Pending',
                'count' => count($pendingShifts),
                'color' => 'pink',
                'class' => 'red'
            ],
            [
                'title' => 'Completed',
                'count' =>  count($completedShifts),
                'color' => 'green',
                'class' => 'green'
            ],
            [
                'title' => 'Allocated Yello',
                'count' => count($yelloAllocatedShifts),
                'color' => 'yellow',
                'class' => 'yellow'
            ],
            [
                'title' => 'Allocated',
                'count' => count($allocatedShifts),
                'color' => '#e4e7ea'
            ],
        ];
        $drivers = Driver::find()->all();
        $user = \Yii::$app->user->identity;
        $favouriteDrivers = StoreOwnerFavouriteDrivers::findAll(['storeOwnerId' => $user->storeOwner->id]);
        $storeCurrent = $user->getStoreCurrent();
        $storeDrivers = DriverHasStore::findAll(['storeId' => $storeCurrent->id]);
        $driverItems = [
            [
                'title' => 'Favorite Drivers',
                'count' => count($favouriteDrivers),
                'color' => 'blue',
                'class' => 'blue'
            ],
            [
                'title' => 'Yello Drivers',
                'count' => count($drivers),
                'color' => 'yellow',
                'class' => 'yellow'
            ],
            [
                'title' => 'Store drivers',
                'count' => count($storeDrivers),
                'color' => '#e4e7ea',
            ]
        ];
        return $this->render('index', [
            'shiftCount' => count($shifts),
            'driverCount' => count($drivers),
            'shiftItems' => $shiftItems,
            'driverItems' => $driverItems
        ]);
    }
}