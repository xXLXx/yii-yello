<?php
use frontend\widgets\StoreForm\StoreFormWidget;
use frontend\widgets\SettingsLeftNavigation;
$this->title = \Yii::t('app', 'Add New Store');
?>

<div class="sidebar-container">
    <?= SettingsLeftNavigation::widget(); ?>
<div class="col-right">
    <h2><?= $this->title ?></h2>
    <?= StoreFormWidget::widget(); ?>
</div>
</div>