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
            <?= Html::a(\Yii::t('app', 'Go to Login'), ['/site/login'], ['class' => 'btn blue']); ?>

            <div class="center">
                <br/>
                <?php if($user_email){
                    echo Html::a(\Yii::t('app', 'Resend Verification'), ['site/resend-verification/', 'user_email' => $user_email], [
                        'class' => 'gray-text'
                    ]);
                }
                ?>
            </div>
        </div>
    </div>
    <div class="sign-up-info">
        <?= \Yii::t('app', 'Don\'t have an account?'); ?>
        <?= Html::a(\Yii::t('app', 'Sign Up'), ['site/signup']); ?>
    </div>
</div>
