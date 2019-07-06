<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */


// restrict driver access to driver domain names and store access to store domain names
$request = Yii::$app->request->hostInfo;
$signuprole=6; //store by default
$signuptitle = "Store";
// add driverdev.localhost to your hosts file for development
$drivers = array('https://transit.driveyello.com','https://driver.yello.delivery','https://prod1driver.yello.delivery','https://driverdev.yello.delivery','http://driverdev.localhost');
if(in_array($request, $drivers)){
    $signuprole=3; // driver
    $signuptitle="Driver";
}



$this->title = $signuptitle.' Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-container-inner">
    <div class="login-popup width-340">
        <div class="login-form">
            <?php
            $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => '{input}{error}',
                    'horizontalCssClasses' => [
                        'error' => 'error-message'
                    ]
                ],
            ]);
            ?>
            <h2 class="center"><?= $signuptitle.' '. \Yii::t('app', 'Sign In'); ?></h2>

            <?php if( count($model->getErrors('login')) > 0 ): ?>
                <div class="red-error-text center">
                    <span class="text-icon icon-red font-exclamation-triangle">
                        <?= \Yii::t('app', 'Your email or password was incorrect.'); ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php if( count($model->getErrors('wrongsite')) > 0 ): ?>
                <div class="red-error-text center">
                    <span class="text-icon icon-red font-exclamation-triangle">
                        <?= \Yii::t('app', 'Invalid login for this site.'); ?>
                    </span>
                </div>
            <?php endif; ?>

            <?=
            $form->field($model, 'email')->textInput([
                'class' => 'text-input placeholder',
                'placeholder' =>  \Yii::t('app', 'Email')
            ]);
            ?>
            <?=
            $form->field($model, 'password')->passwordInput([
                'class' => 'text-input placeholder',
                'placeholder' => \Yii::t('app', 'Password')
            ]);
            ?>
            <?=
            Html::submitButton(\Yii::t('app', 'Sign In'), [
                'class' => 'btn blue uppercase disableme',
                'name' => 'login-button',
                'data-disabledmsg' => 'Validating...'
            ]);
            ?>
            <div class="center">
                <?=
                Html::a(\Yii::t('app', 'Forgot password?'), ['site/request-password-reset'], [
                    'class' => 'gray-text'
                ]);
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="sign-up-info">
        <?= \Yii::t('app', 'Don\'t have an account?'); ?>
        <?= Html::a(\Yii::t('app', 'Sign Up'), ['site/signup']); ?>
    </div>
</div>
