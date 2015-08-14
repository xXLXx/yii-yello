<?php

namespace frontend\controllers;

use common\models\Shift;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Shift storeOwner controller
 *
 * @author markov
 */
class ShiftStoreOwnerController extends BaseController 
{
    /**
     * Store owner accept to driver
     * 
     * @param integer $driverId
     * @param integer $shiftId
     * 
     * @throws NotFoundHttpException;
     */
    public function actionApplicantAccept($driverId, $shiftId)
    {
        $shift = Shift::findOne($shiftId);
        if (!$shift) {
            throw new NotFoundHttpException('Shift not found');
        }
        $isMine = \common\models\DriverHasStore::findOne(['AND', ['driverId'=>$driverId,   'storeId'=>$shift->storeId,'isAcceptedByDriver'=>1]]);
        if($isMine){
            $shift->setStateAllocated($driverId);
        }else{
            $isFavourite = \common\models\StoreOwnerFavouriteDrivers::findOne(['AND', ['driverId'=>$driverId,   'storefk'=>$shift->storeId,'isAcceptedByDriver'=>1]]);
            if($isFavourite){
                // according to spec, when allocating a shift to a favourite driver, the driver becomes a mydriver
                // add to DriverHasStore
                $dhs = new \common\models\DriverHasStore();
                $dhs ->driverId = $driverId;
                $dhs ->storeId = $shift->storeId;
                $dhs ->isAcceptedByDriver=1;
                $dhs ->isInvitedByStoreOwner=1;
                $dhs->save();
            
                // now that the driver is a favourite, remove from store
                $isFavourite->isArchived=1;
                $isFavourite->save();
            }
            $shift->setStateYelloAllocated($driverId);
        }
    }
    
    /**
     * Store owner accept to driver
     * 
     * @param integer $driverId
     * @param integer $shiftId
     * 
     * @throws NotFoundHttpException;
     */
    public function actionApplicantDecline($driverId, $shiftId)
    {
        $shift = Shift::findOne($shiftId);
        if (!$shift) {
            throw new NotFoundHttpException('Shift not found');
        }
        $shift->driverDecline($driverId);
    }
    
    /**
     * Store owner unassign driver
     * 
     * @param integer $driverId
     * @param integer $shiftId
     * 
     * @throws NotFoundHttpException;
     */
    public function actionDriverUnassign($driverId, $shiftId)
    {
        $shift = Shift::findOne($shiftId);
        if (!$shift) {
            throw new NotFoundHttpException('Shift not found');
        }
        if (!$shift->isMyDrivers) {
            $shift->unassignDriver($driverId);
        } else {
            return Json::encode([
                'redirectUrl' => Url::to([
                    'shifts-calendar/shift-edit', 
                    'shiftId'               => $shift->id,
                    'ShiftForm[driverId]'   => 0
                ])
            ]);
        }
    }
    
    /**
     * Store owner approve
     * 
     * @param integer $shiftId
     * 
     * @throws NotFoundHttpException;
     */
    public function actionShiftApprove($shiftId)
    {
        $shift = Shift::findOne($shiftId);
        if (!$shift) {
            throw new NotFoundHttpException('Shift not found');
        }
        // find the latest number
        $count = $shift->deliveryCount;
        $drivercount = $shift->LastDriverShiftRequestReview;
        if($drivercount){
            $count = $drivercount->deliveryCount;
        }
        $money = $count*5;
        if($money<60){
            $money=60;
        }
        $shift->setStateCompleted($count,$money); 
    }
}
