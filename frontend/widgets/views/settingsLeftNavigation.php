<?php
use frontend\widgets\Navigation;
?>

<div class="col-left">
    <h2><?= \Yii::t('app', 'Settings'); ?></h2>
    <div class="sidebar-menu">
        <h5><?= \Yii::t('app', 'Preferences'); ?></h5>
        <?= 
            Navigation::widget([
                'items' => $menuItems
            ]); 
        ?>
    </div>
</div>