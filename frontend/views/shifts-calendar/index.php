<?php

use frontend\widgets\ShiftForm\ShiftFormWidget;
use frontend\widgets\ShiftView\ShiftViewWidget;
use frontend\widgets\ShiftStatesCount\ShiftStatesCountWidget;

use yii\helpers\Html;
use frontend\assets\ShiftsCalendarAsset;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\Pjax;

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
                <div class="item datepicker-group">
                    <?=
                        DatePicker::widget([
                            'attribute'     => 'date',
                            'dateFormat'    => 'dd-MM-yyyy',
                            'options' => [
                                'class'         => 'text-input small datepicker-hidden',
                            ]
                        ]);
                    ?>
                    <span class="icon-calendar-2"></span>
                </div>
            </div>
            <div class="period-list clearfix">
                <div class="item"><span class="font-chevron-left"></span></div>
                <div class="item" id="choosetoday"><?= \Yii::t('app', 'Today'); ?></div>
                <div class="item"><span class="font-chevron-right js_roster_next"></span></div>

            </div>
        </div>
        <h1 class="with-button">
            <span class="js-month-title"></span>
            
                <a href="#" class="btn blue small" id="shift-add-bth" >Add Shift</a>

                        
            <a class="j_colorbox js_copy_roster btn small" href="<?= Url::to(['/shift-weekly-copy']); ?>"><?= \Yii::t('app', 'Copy roster'); ?></a>
            <a class="js_confirm_roster btn small green hidden" href="<?= Url::to(['/shift-weekly-copy/confirm']); ?>"><?= \Yii::t('app', 'Confirm roster'); ?></a>
            <a class="js_cancel_confirmation btn small red hidden" href="<?= Url::to(['/shift-weekly-copy/cancel-confirm']); ?>"><?= \Yii::t('app', 'Cancel'); ?></a>
        </h1>
        <?= ShiftStatesCountWidget::widget([]); ?>

        <div class="calendar-wrapper"></div>
    </div>
    <div class="hidden"><?php echo \kartik\rating\StarRating::widget(['value' => 3]); ?></div>
</div>

<?php
    $this->registerJs("ShiftsCalendarController.init({ storeId: '$store->id', 'sourceUrl': '$sourceUrl', 'copyWeeklySheetUrl': '$copyWeeklySheetUrl'});");
    $this->registerJs('ShiftRequestReviewController.init();');
?>