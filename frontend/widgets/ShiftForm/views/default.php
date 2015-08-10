<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use frontend\widgets\DriverSearch\DriverSearchWidget;
use frontend\widgets\Timepicker\TimepickerWidget;
use yii\widgets\Pjax;
use frontend\widgets\ShiftForm\assets\ShiftFormAsset;

ShiftFormAsset::register($this);

$title = $model->id ? 'Edit shifts' : 'Add Shifts';

?>

<?php
    Pjax::begin([
        'id' => "shift-form-widget-pjax",
        'enablePushState' => true,
        'linkSelector'    => '.js-pjax',
        'timeout'         => 30000
    ]);
?>

<h2><?= \Yii::t('app', $title) ?></h2>
<div class="assigned-shifts-filter <?php if($model->driverId): ?>allocate<?php endif; ?>">
    <?php
        $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'id' => 'shift-form',
            'fieldConfig' => [
                'template' => '{input}{error}',
                'horizontalCssClasses' => [
                    'error' => 'error-message'
                ]
            ],
            'options' => [
                'enctype'   => 'multipart/form-data',
                'data-pjax' => 1
            ]
        ]);
    ?>
        <?= Html::activeHiddenInput($model, 'id'); ?>
        <?= Html::activeHiddenInput($model, 'storeId'); ?>
        <?= Html::errorSummary($model); ?>
        <div class="input-wrapp date">
            <div class="text-block"><?= \Yii::t('app', 'Date') ?></div>
            <?=
                DatePicker::widget([
                    'model'         => $model,
                    'attribute'     => 'date',
                    'dateFormat'    => 'dd-MM-yyyy',
                    'options' => [
                        'class'         => 'text-input small',
                        'placeholder'   => \Yii::t('app', 'Select date')
                    ]
                ]);
            ?>
        </div>
        <div class="input-wrapp time">
            <div class="text-block"><?= \Yii::t('app', 'Time') ?></div>
            <?=
                TimepickerWidget::widget([
                    'name'  => $model->formName() . '[start]',
                    'value' => $model->start,
                    'options' => [
                        'class'         => 'select-70 text-input small without-right-radius',
                        'placeholder'   => \Yii::t('app', 'Start')
                    ]
                ]);
            ?>
            <?=
                TimepickerWidget::widget([
                    'name'  => $model->formName() . '[end]',
                    'value' => $model->end,
                    'options' => [
                        'class' => 'select-70 f-right text-input small',
                        'placeholder'   => \Yii::t('app', 'End')
                    ]
                ]);
            ?>
            <div class="text-block f-right">&ndash;</div>
        </div>
        <!--<div class="middle-gray-text"><?= \Yii::t('app', 'Min. duration 3 hours') ?></div>-->
        <div class="inline-input-block">
            <label class="bold-text"><?= \Yii::t('app', 'Vehicle') ?></label>
            <div class="j_radio_container">
                <div class="radio-input">
                    <input id="vehicle-1" name="<?= $model->formName(); ?>[isVehicleProvided]" value=0
                        type="radio" <?php if (!$model->isVehicleProvided): ?>checked="checked"<?php endif; ?> >
                    <label class="j_radio <?php if (!$model->isVehicleProvided): ?>active<?php endif; ?>" for="vehicle-1"><?= \Yii::t('app', 'Driver Owned'); ?></label>
                </div>
                <div class="radio-input">
                    <input id="vehicle-2" name="<?= $model->formName(); ?>[isVehicleProvided]"  value=1
                        type="radio" <?php if ($model->isVehicleProvided): ?>checked="checked"<?php endif; ?> >
                    <label class="j_radio <?php if ($model->isVehicleProvided): ?>active<?php endif; ?>" for="vehicle-2"><?= \Yii::t('app', 'Provided'); ?></label>
                </div>
            </div>
        </div>
        <div class="inline-input-block">
            <label class="bold-text"><?= \Yii::t('app', 'Driver') ?></label>
            <div class="j_checkbox_container js-driver-visible-group-container">
                <div class="checkbox-input">
                    <input class="js-driver-group-radio"
                        id="driver-1" name="<?= $model->formName() . '[visibleGroup][]' ?>" value="isYelloDrivers"
                        type="checkbox" <?php if ($model->isYelloDrivers): ?>checked="checked"<?php endif; ?> >
                    <label class="j_checkbox <?php if ($model->isYelloDrivers): ?>active<?php endif; ?>" for="driver-1"><?= \Yii::t('app', 'Yello'); ?></label>
                </div>
                <div class="checkbox-input">
                    <input class="js-driver-group-radio"
                        id="driver-2" name="<?= $model->formName() . '[visibleGroup][]' ?>" value="isFavourites"
                        type="checkbox" <?php if ($model->isFavourites): ?>checked="checked"<?php endif; ?> >
                    <label class="j_checkbox <?php if ($model->isFavourites): ?>active<?php endif; ?>" for="driver-2"><?= \Yii::t('app', 'Favourites'); ?></label>
                </div>
                <div class="checkbox-input">
                    <input class="js-driver-group-radio"
                        id="driver-3" name="<?= $model->formName() . '[visibleGroup][]' ?>" value="isMyDrivers"
                        type="checkbox" <?php if ($model->isMyDrivers): ?>checked="checked"<?php endif; ?> >
                    <label class="j_checkbox <?php if ($model->isMyDrivers): ?>active<?php endif; ?>" for="driver-3"><?= \Yii::t('app', 'My Driver(s)'); ?></label>
                </div>
            </div>
        </div>

        <div class="js-driver-search-container hide">
            <?=
                DriverSearchWidget::widget([
                    'model' => $model
                ]);
            ?>
        </div>

        <div class="border-top-block">
            <?=
                Html::submitButton(\Yii::t('app', 'Post Shift'), [
                    'class' => 'btn blue post-submit'
                ]);
            ?>
            <?=
                Html::submitButton(\Yii::t('app', 'Allocate Shift'), [
                    'class' => 'btn blue allocate-submit'
                ]);
            ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
    $this->registerJs('ShiftFormWidget.init();');
?>

<?php Pjax::end(); ?>