<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Activation';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-container-inner">
    <div class="login-popup width-340">
        <div class="select-form">
            <h2 class="center"><?= \Yii::t('app', 'Activation'); ?></h2>
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="center" role="alert">
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>
            <br/>
            <?= Html::a(\Yii::t('app', 'Ok'), ['/site/login'], ['class' => 'btn blue']); ?>
        </div>
    </div>
</div>
