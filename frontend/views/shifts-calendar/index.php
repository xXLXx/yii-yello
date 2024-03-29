<?php

use frontend\widgets\ShiftForm\ShiftFormWidget;
use frontend\widgets\ShiftView\ShiftViewWidget;
use frontend\widgets\ShiftStatesCount\ShiftStatesCountWidget;

use yii\helpers\Html;
use frontend\assets\ShiftsCalendarAsset;
use yii\helpers\Url;

ShiftsCalendarAsset::register($this);

$sourceUrl = Url::to(['shifts-calendar/get-events']); 
$copyWeeklySheetUrl = Url::to(['shift-weekly-copy/copy']);
    
?>
<div class="sidebar-container sidebar-actions <?php if (!$mode): ?>without-col-left<?php endif; ?>">
    <div class="col-left">
        <?php if (!$mode || $mode == 'shiftForm'): ?>
            <?= ShiftFormWidget::widget([
                'shiftId' => $shiftId,
                'storeId' => $store->id
            ]); ?>
        <?php endif; ?>
        <?php if ($mode == 'shiftView'): ?>
            <?= ShiftViewWidget::widget([
                'shiftId' => $shiftId
            ]); ?>
        <?php endif; ?>
    </div>
    <div class="col-right">
        <div class="f-right top-right-container">
            <div class="period-list clearfix">
                <div class="item"><span class="icon-calendar-2"></span></div>
            </div>
            <div class="period-list clearfix">
                <div class="item"><span class="font-chevron-left"></span></div>
                <div class="item" id="choosetoday"><?= \Yii::t('app', 'Today'); ?></div>
                <div class="item"><span class="font-chevron-right"></span></div>
            </div>
        </div>
        <h1 class="with-button">
            <span class="js-month-title"></span>
            <?= 
                Html::a(\Yii::t('app', 'Add Shift'), ['shifts-calendar/shift-add'], [
                    'class' => 'btn blue small',
                    'id' => 'shift-add-bth'
                ]) 
            ?>
            <span class="js-copy-weekly-sheet btn small"><?= \Yii::t('app', 'Copy weekly sheet'); ?></span>
        </h1>
        <?= ShiftStatesCountWidget::widget([]); ?>

        <div class="calendar-wrapper"></div>
    </div>
</div>

<?php
    $this->registerJs("ShiftsCalendarController.init({ storeId: '$store->id', 'sourceUrl': '$sourceUrl', 'copyWeeklySheetUrl': '$copyWeeklySheetUrl'});");
    $this->registerJs('ShiftRequestReviewController.init();'); 
?>