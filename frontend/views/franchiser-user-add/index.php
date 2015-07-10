<?php

use frontend\widgets;
use frontend\widgets\UserAdd\FranchiserManagerWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->registerJsFile('/js/ImageUploadPreview.js');
$this->registerJs('ImageUploadPreview.init();');
?>
<div class="sidebar-container">
    <?= widgets\SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <h2><a href="<?= Url::to(['settings/users']); ?>" class="middle-gray-text">
                <?= \Yii::t('app', 'Manage Users'); ?></a> / <?= \Yii::t('app', 'Add User'); ?></h2>
        <?=
        FranchiserManagerWidget::widget([
            'roleId' => $roleId
        ]);
        ?>
    </div>
</div>