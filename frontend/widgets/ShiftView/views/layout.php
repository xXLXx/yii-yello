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
        'linkSelector'    => '.js-pjax'
    ]); 
?>

    <?php if ($shift->isEditable()): ?>
    <a class="btn blue small f-right top-right-button js-pjax" 
       href="<?= Url::to(['shifts-calendar/shift-edit', 'shiftId' => $shift->id]); ?>">
        <span class="font-pencil"></span>
    </a>
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
