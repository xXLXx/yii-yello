<?php use \yii\helpers\Html; ?>

<div class="popup width-340">
    <div class="popup-title">
        <h3><?= \Yii::t('app', 'Copy weekly sheet'); ?></h3>
    </div>
    <div class="popup-body">
        <div class="popup-body-inner request-review">
            <?= Html::beginForm('/shift-weekly-copy', 'POST', ['id' => 'js_frm-copy-weekly-sheet']); ?>
            <p>This will copy this current weeks shift schedule to next week. Would you like to also like to reassign all shifts to your stores drivers?</p>
            <p><?= Html::radioList('assign', ['yes'], ['yes' => 'Yes', 'no' => 'No']); ?></p>

            <div class="button-container text-right">
                <button class="btn j_colorbox_close"><?= \Yii::t('app', 'Cancel'); ?></button>
                <?= Html::submitButton(\Yii::t('app', 'Continue'), [
                    'class' => 'btn blue',
                ]); ?>
            </div>

            <?= Html::endForm(); ?>
        </div>
    </div>
</div>