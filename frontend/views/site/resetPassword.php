<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-container-inner">
    <div class="login-popup width-340">
        <div class="login-form">
            <div class="site-reset-password">
                <h2><?= Html::encode($this->title) ?></h2>

                <p>Please choose your new password:</p>

                <div class="row">

                    <?php
                    $form = ActiveForm::begin([
                                'layout' => 'horizontal',
                                'id' => 'reset-password-form',
                                'fieldConfig' => [
                                    'template' => '{input}{error}',
                                    'horizontalCssClasses' => [
                                        'error' => 'error-message'
                                    ]
                                ],
                    ]);
                    ?>
                    <?=
                    $form->field($model, 'password')->passwordInput([
                        'class' => 'text-input placeholder',
                        'placeholder' => \Yii::t('app', 'Password')
                    ]);
                    ?>
                    <?=
                    $form->field($model, 'password_repeat')->passwordInput([
                        'class' => 'text-input placeholder',
                        'placeholder' => \Yii::t('app', 'Repeat Password')
                    ]);
                    ?>
                    <?=
                    Html::submitButton(\Yii::t('app', 'Save'), [
                        'class' => 'btn blue uppercase disableme',
                        'name' => 'login-button',
                        'data-disabledmsg' => 'Saving'
                    ]);
                    ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>