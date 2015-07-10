<?php
use frontend\widgets;
use frontend\widgets\UserEdit\UserEditWidget;
/* @var $this yii\web\View */
$this->title = \Yii::t('app', 'Manage Account / Yello');
$this->registerJsFile('/js/ImageUploadPreview.js');
$this->registerJs('ImageUploadPreview.init();');
?>
<div class="sidebar-container">
    <?= widgets\SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <h2><?= $this->title ?></h2>
        <?= 
            UserEditWidget::widget([
                'user'      => \Yii::$app->user->identity,
                'pageName'  => 'manageAccount'
            ]);
        ?>
    </div>
</div>