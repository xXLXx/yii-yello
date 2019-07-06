<?php
    use frontend\widgets\DriverSearch\assets\DriverSearchAsset;
    use yii\helpers\Html;
    use frontend\widgets\DriverSearchAutocompleteSelected\DriverSearchAutocompleteSelectedWidget;
    DriverSearchAsset::register($this);
?>

<input 
    class="js-driver-search-widget-search text-input small search" 
    placeholder="<?= \Yii::t('app', 'Search driver and assign') ?>" type="text"/>
<div class="js-driver-search-widget-results" style="position:relative;">
    <?= Html::hiddenInput($formName . '[driverId]', $model->driverId, ['class' => 'js-driver-input']); ?>
    <div class="search-select-popup j_scrollpane j_search_select" style="display:none;"></div>
    <div class="j_search_select_drivers" <?php if (!$model->driverId): ?>style="display:none;"<?php endif; ?>>
        <?= 
            DriverSearchAutocompleteSelectedWidget::widget([
                'driverId'    => $model->driverId
            ]); 
        ?>
    </div>
</div>
<?= $this->registerJs("DriverSearchWidget.init($paramsJson);"); ?>