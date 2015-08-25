<?php
/**
 * Shift state behavior
 */

namespace common\behaviors\shift;

use common\behaviors\BaseBehavior;
use common\models\Shift;
use common\models\ShiftState;
use common\models\ShiftStateLog;
use common\models\DriverHasStore;

/**
 * Class ShiftStateBehavior
 * @package common\behaviors\shift
 *
 * @author markov
 *
 * @property Shift $owner Behavior's shift model
 */
class ShiftStateBehavior extends BaseBehavior
{
    /**
     * Process shift state change
     */
    public function processShiftState()
    {
        $dirtyAttributes = $this->owner->getDirtyAttributes();
        if (!empty($dirtyAttributes) && is_array($dirtyAttributes) && !empty($dirtyAttributes['shiftStateId'])) {
            $shiftStateLog = new ShiftStateLog();
            $shiftStateLog->shiftStateId = $dirtyAttributes['shiftStateId'];
            $shiftStateLog->shiftId = $this->owner->id;
            $shiftStateLog->save();
        }
    }

    /**
     * Active
     */
    public function setStateActive()
    {
        $this->setStateByName(ShiftState::STATE_ACTIVE);
        $shift = $this->owner;
        if (empty($shift->actualStart)) {
//            $timeZone = new \DateTimeZone('UTC');
//            $dt = new \DateTime('now', $timeZone);
            $dt = new \DateTime('now');
            $shift->actualStart = $dt->format('Y-m-d H:i:s');
        }
        $shift->update();
    }
    
    /**
     * Active
     * 
     * @param integer $deliveryCount delivery count
     * @param integer $payment payment
     */
    public function setStateCompleted($deliveryCount, $payment)
    {
        $this->setStateByName(ShiftState::STATE_COMPLETED);
        $shift = $this->owner;
        $shift->deliveryCount = $deliveryCount;
        $shift->payment = $payment;
        $shift->update();
    }
    
    /**
     * Set the shift's state to approval
     *
     * @param integer $deliveryCount   Shift's deliveries count
     * @param integer $payment          Total shift payment
     */
    public function setStateApproval($deliveryCount, $payment)
    {
        $this->setStateByName(ShiftState::STATE_APPROVAL);
        $shift = $this->owner;
        $shift->actualEnd = (new \DateTime())->format("Y-m-d H:i:s");
        $shift->deliveryCount = $deliveryCount;
        $shift->payment = $payment;
        $shift->update();
    }
    
    /**
     * Allocated
     * 
     * @param integer $driverId driver id
     */
    public function setStateAllocated($driverId)
    {
        $state = ShiftState::STATE_YELLO_ALLOCATED;
        $storeid = $this->owner->storeId;
        $my = DriverHasStore::find([['AND'],'driverId'=>$driverId,'storeId'=>$storeid,'isArchived'=>0]);
        if($my){
            $state = ShiftState::STATE_ALLOCATED;
        }
        
        $shiftHasDriver = $this->owner->addDriver($driverId);
        $shiftHasDriver->acceptedByStoreOwner = true;
        $shiftHasDriver->update();
        $this->setStateByName($state);
        $this->owner->update();
    }
    
    /**
     * Yello allocated
     * 
     * @param integer $driverId driver id
     */
    public function setStateYelloAllocated($driverId)
    {
        $state = ShiftState::STATE_YELLO_ALLOCATED;
        $storeid = $this->owner->storeId;
        $my = DriverHasStore::find([['AND'],'driverId'=>$driverId,'storeId'=>$storeid]);
        if($my){
            $state = ShiftState::STATE_ALLOCATED;
        }
        
        $shiftHasDriver = $this->owner->addDriver($driverId);
        $shiftHasDriver->acceptedByStoreOwner = true;
        $shiftHasDriver->update();
        $this->setStateByName($state);
        $this->owner->update();
    }
    
    /**
     * Pending
     */
    public function setStatePending()
    {
        $this->setStateByName(ShiftState::STATE_PENDING);
        $this->owner->update();
    }

    /**
     * Disputed
     */
    public function setStateDisputed()
    {
        $this->setStateByName(ShiftState::STATE_DISPUTED);
        $this->owner->update();
    }

    /**
     * Pending payment
     */
    public function setStatePendingPayment()
    {
        $this->setStateByName(ShiftState::STATE_PENDING_PAYMENT);
        $this->owner->update();
    }

    /**
     * Under review
     */
    public function setStateUnderReview()
    {
        $this->setStateByName(ShiftState::STATE_UNDER_REVIEW);
        $this->owner->update();
    }

    /**
     * Set shiftStateByName
     * 
     * @param string $shiftStateName name
     */
    public function setStateByName($shiftStateName)
    {
        /** @var ShiftState $shiftState */
        $shiftState = ShiftState::findOne(['name' => $shiftStateName]);
        $this->owner->shiftStateId = $shiftState->id;
    }
}
