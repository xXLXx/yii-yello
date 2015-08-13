<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-container-inner">
    <div class="login-popup width-460 j_first_step">
        <div class="register-form">
            <?php
                $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'id' => 'signup-form',
                    'fieldConfig' => [
                        'template' => '{input}{error}',
                        'horizontalCssClasses' => [
                            'error' => 'error-message'
                        ]
                    ],
                ]); 
            ?>
                <h2 class="center"><?= \Yii::t('app', 'Sign Up'); ?></h2>
                <table>
                    <colgroup><col width="96">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th><label for="email"><?= \Yii::t('app', 'Email'); ?></label></th>
                            <td>
                                <?= 
                                    $form->field($model, 'email')->textInput([
                                        'class' => 'text-input',
                                        'id'    => 'email'
                                    ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="userName"><?= \Yii::t('app', 'First Name'); ?></label></th>
                            <td>
                                <?= 
                                    $form->field($model, 'firstName')->textInput([
                                        'class' => 'text-input',
                                        'id' => 'userName'
                                    ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="userLastName"><?= \Yii::t('app', 'Last Name') ?></label></th>
                            <td>
                                <?= 
                                    $form->field($model, 'lastName')->textInput([
                                        'class' => 'text-input',
                                        'id' => 'userLastName'
                                    ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="pass"><?= \Yii::t('app', 'Password') ?></label></th>
                            <td>
                                <?= 
                                    $form->field($model, 'password')->passwordInput([
                                        'class' => 'text-input',
                                        'id' => 'pass'
                                    ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="confirm"><?= \Yii::t('app', 'Confirm') ?></label></th>
                            <td>
                                <?= 
                                    $form->field($model, 'confirm')->passwordInput([
                                        'class' => 'text-input',
                                        'id' => 'confirm'
                                    ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="userRole"><?= \Yii::t('app', 'Register as'); ?></label></th>
                            <td>
                                <?= $form->field($model, 'roleId')
                                    ->dropDownList($model->getRoleArrayMap(), [
                                        'id' => 'userRole',
                                        'class' => 'j_select select-220'
                                    ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <div class="checkbox-input">
                                    <?= Html::checkbox('SignupForm[isAccepted]', $model->isAccepted, ['id' => 'agreement']) ?>
                                    <label for="agreement" class="j_checkbox <?php if ($model->isAccepted): ?>active<?php endif; ?>">
                                        <?= \Yii::t('app', 'I Accept Terms &amp; Conditions'); ?>
                                    </label>
                                    <?= Html::error($model, 'isAccepted', [
                                        'class' => 'help-block help-block-error error-message'
                                    ]); ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right clearfix">
                    <?=
                        Html::submitButton(\Yii::t('app', 'Submit'), [
                            'class' => 'btn blue uppercase f-right disableme', 
                            'name' => 'login-button'
                        ]); 
                    ?>
                    <?= Html::a(\Yii::t('app', 'I already have an account'), ['site/login']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<!--    <div class="login-popup width-340 j_second_step">
        <div class="login-form">
            <form action="">
                <h2 class="center">Activate account</h2>
                <div class="center">Please verify your email address.<br>Email with instructions to activate your account was sent, check your email.</div>
                <div class="button-container center">
                    <div onclick="$('.j_second_step').hide(); $('.j_third_step').show();" class="btn blue">Ok</div>
                </div>
            </form>
        </div>
    </div>
    <div class="login-popup width-340 j_third_step">
        <div class="login-form">
            <form action="">
                <h2 class="center">Account activated</h2>
                <div class="center">Account is successfully activated.<br>Now you can sign in.</div>
                <br>
                <div class="button-container center">
                    <a class="btn blue" href="sign-in.html">Sign in</a>
                </div>
            </form>
        </div>
    </div>-->
</div>
