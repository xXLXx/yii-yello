<?php
    use yii\helpers\Html;
?>
<!--? //php if($canSetIsAdmin): ?>
<p class="text-icon font-exclamation-triangle gray-text icon-orange">
    < //?= \Yii::t('app', 'Admins have full access to user management, import/export, upgrade, and apply account customizations.'); ?>
</p>

<//?php endif; ?>-->
<div class="checkbox-input">
    <input id="blockUser" type="checkbox" <?php if ($model->isBlocked): ?>checked="checked"<?php endif ?> value="1" id="blocking" name="<?= $model->formName() ?>[isBlocked]">
    <label for="blockUser" class="j_checkbox <?php if ($model->isBlocked): ?>active<?php endif ?>">Temporary block User</label>
</div>
<div class="border-top-block">
    <?= Html::resetButton(\Yii::t('app', 'Cancel'), ['class' => 'btn']); ?>
    <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn blue']); ?>
</div>