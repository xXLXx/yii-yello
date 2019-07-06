<?php
use frontend\widgets\Navigation;
?>

<div class="col-left">
    <h2><?= \Yii::t('app', 'Settings'); ?></h2>
    <div class="sidebar-menu">
        <?php 
        foreach ($menuItems as $item){
            ?>
        <h5><?= $item['heading'] ?></h5>
        <?= 
            Navigation::widget([
                'items' => $item['menuItems']
            ]); 
        ?>
        &nbsp;<br />
        
                <?php
        }
        ?>
        
    </div>
</div>