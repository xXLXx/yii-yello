<?php
use frontend\widgets\StoreForm\StoreFormWidget;
use frontend\widgets\SettingsLeftNavigation;
$this->title = \Yii::t('app', 'Edit Store');
$this->registerJsFile('/js/ImageUploadPreview.js');
$this->registerJs('ImageUploadPreview.init();');
?>
<div class="sidebar-container">
    <?= SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <h2><?= $this->title ?></h2>
        <?= StoreFormWidget::widget(); ?>
    </div>
</div>