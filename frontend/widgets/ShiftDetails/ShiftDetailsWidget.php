<?php

namespace frontend\widgets\ShiftDetails;

use common\models\ShiftState;
use yii\base\Widget;
use common\models\Shift;
use common\models\ShiftReviews;

/**
 * Class ShiftDetailsWidget
 * @package frontend\widgets\ShiftDetails
 *
 * @author Yarovikov
 */
class ShiftDetailsWidget extends Widget
{

    public $shift;
    public $lastDeliveryCount;
    public $review;

    public function run()
    {
        if ( $this->shift instanceof Shift ) {

            $shiftState = $this->shift->shiftState;

            if(empty($this->review) || !($this->review instanceof ShiftReviews)){
                if($shiftState->name == ShiftState::STATE_COMPLETED){
                    $this->review = ShiftReviews::findOne(['shiftId' => $this->shift->id]);
                }
            }

            if(empty($this->lastDeliveryCount)){
                $this->lastDeliveryCount = $this->shift->deliveryCount;
            }

            return $this->render('shiftDetails', [
                'shift' => $this->shift,
                'shiftState' => $shiftState,
                'lastDeliveryCount' => $this->lastDeliveryCount,
                'review' => $this->review,
            ]);
        }

        return '';
    }

}