<?php

use frontend\widgets\SettingsLeftNavigation;
use frontend\widgets\UserEdit\UserEditWidget;

/* @var $this yii\web\View */
$this->title = \Yii::t('app', 'Manage Users / Edit User: ') . $user->username;
$this->registerJsFile('/js/ImageUploadPreview.js');
$this->registerJs('ImageUploadPreview.init();');
?>
<div class="sidebar-container">
    <?= SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <h2><?= $this->title ?></h2>
        <?= 
            UserEditWidget::widget([
                'user'      => $user,
                'pageName'  => 'userEdit'
            ]);
        ?>
    </div>
</div>