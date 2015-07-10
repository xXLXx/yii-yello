<?php
    use yii\helpers\Html;
?>

<div class="border-top-block">
    <?= Html::submitButton(\Yii::t('app', 'Save Settings'), ['class' => 'btn blue']); ?>
    <?php if ($model->id): ?>
        <p>
            <?= Html::a(\Yii::t('app', 'Delete account'), ['user/delete', 'userId' => $model->id], [
                'class' => 'icon-link font-delete-garbage-streamline'
            ]); ?>
        </p>
        <p class="icon-text font-exclamation-triangle icon-orange"><?= \Yii::t('app', 'Attention! By deleting your account, all data will be permanently deleted.'); ?></p>
    <?php endif; ?>
</div>