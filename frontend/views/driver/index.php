<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Driver Info / Yello';
?>
<div class="login-container-inner">
    <div class="login-popup width-340">
        <div class="select-form">
            <form action="">
                <h2 class="center"><?= \Yii::t('app', 'Driver Website Coming Soon'); ?></h2>
                <p>Thank you for visiting us. Your exclusive driver's website is on its way. Meanwhile you may like to download the app or subscribe using these buttons.</p>
                <?= Html::a(\Yii::t('app', 'Yello Website'), ['https://www.driveyello.com/registration/'], ['class' => 'btn blue']); ?>
                <?= Html::a(\Yii::t('app', 'Download the App'), ['#'], ['class' => 'btn blue']); ?>
            </form>
        </div>
    </div>
</div>