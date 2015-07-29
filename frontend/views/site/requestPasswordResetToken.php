<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = 'Reset Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-container-inner">
    <div class="login-popup width-340">
        <div class="login-form">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <h2 class="center"><?= Html::encode($this->title) ?></h2>
                <div class="j_reset_item">
                    <?= Html::activeTextInput($model, 'email', [
                        'class' => 'text-input j_placeholder placeholder',
                        'placeholder' =>  \Yii::t('app', 'Email'),
                        'alt' => 'Email',
                    ]);
                    ?>
                    <?= Html::error($model, 'email', ['class' => 'help-block help-block-error error-message']) ?>
                    <div class="button-container clearfix">
                        <a href="<?= Url::home() ?>" class="btn f-left">Cancel</a>
                        <?= Html::submitButton('Reset', ['class' => 'btn blue f-right disableme', 'id' => 'resetPassword', 'data-disabledmsg'=>'Processing...', 'data-enabledval'=>'Reset']) ?>
                    </div>
                </div>

                <div class="j_reset_item" style="display:none;">
                    <div>Email with instructions to reset your password was sent. Please check your email.</div>
                    <br>
                    <div class="button-container center">
                        <a href="<?= Url::home() ?>" class="btn blue">Ok</a>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>