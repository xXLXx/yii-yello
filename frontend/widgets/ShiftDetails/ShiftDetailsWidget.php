<?php

namespace frontend\widgets\ShiftDetails;

use yii\base\Widget;
use common\models\Shift;

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

    public function run()
    {
        if ( $this->shift instanceof Shift ) {

            $shiftState = $this->shift->shiftState;

            if(empty($this->lastDeliveryCount)){
                $this->lastDeliveryCount = $this->shift->deliveryCount;
            }

            return $this->render('shiftDetails', [
                'shift' => $this->shift,
                'shiftState' => $shiftState,
                'lastDeliveryCount' => $this->lastDeliveryCount,
            ]);
        }

        return '';
    }

}