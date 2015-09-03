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
        // make sure driver is not busy on another shift
        $start = $shift->start;
        $others = \api\common\models\Shift::getAllocatedFor($driverId)->actualStart;
        //TODO: make sure driver is not already booked on an overlappin shift
        // select * from shifthasdriver where shiftid<>$shiftID and driverid=$driverid and start<=$start and end>=$start;
        
        
        $shift->setStateAllocated($driverId);
        
//        $isMine = \common\models\DriverHasStore::findOne(['AND', ['driverId'=>$driverId,   'storeId'=>$shift->storeId,'isAcceptedByDriver'=>1,'isArchived'=>0]]);
//        if($isMine){
//            $shift->setStateAllocated($driverId);
//        }else{
//            $isFavourite = \common\models\StoreOwnerFavouriteDrivers::findOne(['AND', ['driverId'=>$driverId,   'storefk'=>$shift->storeId,'isAcceptedByDriver'=>1,'isArchived'=>0]]);
//            if($isFavourite){
//                // according to spec, when allocating a shift to a favourite driver, the driver becomes a mydriver
//                // add to DriverHasStore
//                // omitted for the time being
////                $dhs = new \common\models\DriverHasStore();
////                $dhs ->driverId = $driverId;
////                $dhs ->storeId = $shift->storeId;
////                $dhs ->isAcceptedByDriver=1;
////                $dhs ->isInvitedByStoreOwner=1;
////                $dhs->save();
////            
////                // now that the driver is a favourite, remove from store
////                $isFavourite->isArchived=1;
////                $isFavourite->save();
//            }
//            $shift->setStateYelloAllocated($driverId);
//        }
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
        return Json::encode([
                       'result' => 'notfound'
                   ]);

//            throw new NotFoundHttpException('Shift not found');
        }
        // todo: current user can manage current store

        if (1==1) {
            $shift->unassignDriver($driverId);
                    return Json::encode([
                       'result' => 'success'
                   ]);
        } else {
                    return Json::encode([
                       'result' => 'notauthorised'
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
