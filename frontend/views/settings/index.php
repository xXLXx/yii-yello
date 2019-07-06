<?php
use frontend\widgets;

use common\models\Role;
use frontend\widgets\UserEdit\UserEditWidget;
/* @var $this yii\web\View */
$this->title = \Yii::t('app', 'Manage Account / Yello');
$this->registerJsFile('/js/ImageUploadPreview.js');
$this->registerJs('ImageUploadPreview.init();');
$currentUserRoleName = \Yii::$app->user->identity->role->name;
?>
<div class="sidebar-container">
    <?php if($currentUserRoleName!=Role::ROLE_EMPLOYEE){
        echo(widgets\SettingsLeftNavigation::widget()); 
    }
     ?>
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
 <?php if($currentUserRoleName==Role::ROLE_EMPLOYEE){?>
<style>
    .sidebar-container:after {width:0;}
</style>

<?php    }?>
