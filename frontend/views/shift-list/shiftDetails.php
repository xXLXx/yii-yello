<?php

use frontend\widgets\ShiftDetails\ShiftDetailsWidget;
use frontend\widgets\DriverDetails\DriverDetailsWidget;
/**
 * @var $shift \common\models\Shift
 * @var $driver \common\models\Driver
 * @var $lastDeliveryCount String
 */
if(!isset($lastDeliveryCount)){
    $lastDeliveryCount = null;
}

?>
<div class="border-top-list shifts-view">

    <?= DriverDetailsWidget::widget([
        'driver' => $driver,
    ]); ?>

    <?= ShiftDetailsWidget::widget([
        'shift' => $shift,
        'lastDeliveryCount' => $lastDeliveryCount,
    ]); ?>

</div>
