<?php
/**
 * @var $model common\models\Shift
 */
?>
<div class="shift-item <?= $model->shiftState->color; ?>" data-id="<?= $model->id; ?>">
    <h5 class="driver-name">
   
    </h5>
    <div class="state <?= $model->shiftState->color; ?>">
        <?= $model->shiftState->name; ?>
    </div>
    <div>
        <?= date('j F, Y', strtotime($model->start)); ?>
    </div>
    <div>
        <div class="inline-block"><span class="gray-text">Start</span> <?= date('g:ia', strtotime($model->start)); ?></div>
        <div class="inline-block"><span class="gray-text">End</span> <?= date('g:ia', strtotime($model->end)); ?></div>
    </div>
    <a href="#" class="shift-link" data-shift-id="<?= $model->id; ?>" rel="nofollow"></a>
</div>

