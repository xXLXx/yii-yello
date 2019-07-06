<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Select Role / Yello';
?>
<div class="login-container-inner">
    <div class="login-popup width-340">
        <div class="select-form">
            <form action="">
                <h1 class="center"><?= \Yii::t('app', 'Select Role'); ?></h1>
                <?= Html::a(\Yii::t('app', 'Yello Admin'), ['/site/signup'], ['class' => 'btn blue']); ?>
                <?= Html::a(\Yii::t('app', 'Store Owner'), ['/site/signup'], ['class' => 'btn blue']); ?>
                <?= Html::a(\Yii::t('app', 'Franchisers & MA'), ['/site/signup'], ['class' => 'btn blue']); ?>
            </form>
        </div>
    </div>
</div>