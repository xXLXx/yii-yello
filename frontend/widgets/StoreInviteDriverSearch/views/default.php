<?php
    use frontend\widgets\StoreInviteDriverSearch\assets\StoreInviteDriverSearchAsset;
    use yii\helpers\Html;
    use frontend\widgets\StoreInviteDriverSelected\StoreInviteDriverSelectedWidget;
    StoreInviteDriverSearchAsset::register($this);
?>

<input type="text" name="invite_driver_input" class="js-driver-search-widget-search text-input small width-100 j_focus"
    placeholder="<?= \Yii::t('app', 'Enter Yello ID or Email') ?>" />
<div class="js-driver-search-widget-results" style="position:relative;">
    <?= Html::hiddenInput($formName . '[driverId]', $model->driverId, ['class' => 'js-driver-input']); ?>
    <div class="search-select-popup j_scrollpane j_search_select" style="display:none;"></div>
    <div class="j_search_select_drivers" <?php if (!$model->driverId): ?>style="display:none;"<?php endif; ?>>
        <?= 
            StoreInviteDriverSelectedWidget::widget([
                'driverId'    => $model->driverId
            ]); 
        ?>
    </div>
</div>
<?= $this->registerJs("StoreInviteDriverSearchWidget.init($paramsJson);"); ?>