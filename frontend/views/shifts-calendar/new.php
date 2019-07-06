<?php

use frontend\widgets\ShiftForm\ShiftFormWidget;
use frontend\widgets\ShiftView\ShiftViewWidget;
use frontend\widgets\ShiftStatesCount\ShiftStatesCountWidget;

use yii\helpers\Html;
use frontend\assets\ShiftsCalendarAsset;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\Pjax;



?>
        <?php if (!$mode || $mode == 'shiftForm'): ?>
            <?= ShiftFormPWidget::widget([
                'shiftId' => $shiftId,
                'storeId' => $store->id
            ]); ?>
        <?php endif; ?>
