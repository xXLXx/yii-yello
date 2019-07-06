<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use frontend\widgets\ShiftView\assets\ShiftViewAsset;

ShiftViewAsset::register($this);

?>
<?php
    Pjax::begin([
        'id' => "shift-form-widget-pjax",
        'enablePushState' => true,
        'linkSelector'    => '.js-pjax',
//        'timeout'         => 30000
    ]);
?>

    <?php if ($shift->isEditable()): ?>
        <div class="f-right top-right-button">
            <?php if (\Yii::$app->user->can('CancelShift') && $shift->isDeletable) : ?>
            <a id="js-delete-shift" class="btn small"
               href="<?= Url::to(['shifts-calendar/shift-delete', 'shiftId' => $shift->id]); ?>">
                <span class="font-delete-garbage-streamline"></span>
            </a>
            <?php endif; ?>
            <?php if($shift->isEditable){?>
            
            <a class="btn blue small js-pjax"
               href="<?= Url::to(['shifts-calendar/shift-edit', 'shiftId' => $shift->id]); ?>">
                <span class="font-pencil"></span>
            </a>
            <?php }?>
        </div>
    <?php endif; ?>
    <h2 class="with-button">
        <?= \Yii::t('app', 'Shift'); ?>
        <div class="sticker <?= $shift->shiftState->color ?>"><?= \Yii::t('app', $shift->shiftState->title); ?></div>
    </h2>
    <div class="assigned-shifts-filter">
        <?= $this->render('blocks/body', ['shift' => $shift]) ?>
        <?= $this->render($stateName, [
            'shift' => $shift
        ]); ?>
    </div>

<?= $this->registerJs('ShiftViewWidget.init();'); ?>

<?php Pjax::end(); ?>
