<?php

//use frontend\widgets\ShiftList\ShiftListWidget;
use yii\widgets\ListView;
use frontend\assets\ShiftListAsset;
/**
 * @var $this yii\web\View
 * @var $shiftsDataProvider yii\data\ActiveDataProvider
 * @var $currentDay \DateTime
 */

ShiftListAsset::register($this);
?>

<div class="sidebar-container sidebar-actions">
    <div class="col-left">
        <h2>Assigned Shifts</h2>
        <div class="assigned-shifts-filter">

            <div id="shifts-date-widget">
                <div class="period-list clearfix">

                    <input type="hidden" id="date-input" value="<?= $currentDay->format('Y-m-d'); ?>">
                    <div class="item" id="bt-calendar"><span class="icon-calendar-2"></span></div>

                </div>

                <div class="period-list clearfix">
                    <div class="item" id="bt-prev-date"><span class="font-chevron-left"></span></div>
                    <div class="item" id="date-label">Today</div>
                    <div class="item" id="bt-next-date"><span class="font-chevron-right"></span></div>
                </div>

            </div>

            <input id="shifts-list-search" class="text-input small search j_placeholder" type="text" alt="Search">

            <div class="result-title" id="shifts-quantity">
                <?= $shiftsDataProvider->getTotalCount(); ?> Shifts
            </div>

        </div>

        <?= ListView::widget([
            'dataProvider' => $shiftsDataProvider,
            'emptyText' => \Yii::t('app', 'No shifts'),
            'id' => 'shifts-list',
            'itemOptions' => [
                'tag' => false,
            ],
            'itemView' => '_shiftItem',
            'layout' => '{items}',
            'options' => [
                'class' => 'shift-list',
            ],
            'separator' => '',
        ]); ?>

    </div>
    <div class="col-right" id="shift-detail-container"></div>
</div>
