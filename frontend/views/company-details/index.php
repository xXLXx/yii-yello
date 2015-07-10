<?php

use frontend\widgets\SettingsLeftNavigation;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model frontend\models\CompanyForm
 */
$this->title = \Yii::t('app', 'Company Details');
?>
<div class="sidebar-container">
    <?= SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <h2><?= $this->title ?></h2>
        <?php
            $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'id' => 'user-edit-form',
                'fieldConfig' => [
                    'template' => '{input}{error}',
                    'horizontalCssClasses' => [
                        'error' => 'error-message'
                    ]
                ],
            ]); 
        ?>
            <?= Html::activeHiddenInput($model, 'id'); ?>
            <table class="profile-settings">
                <tbody>
                    <tr>
                        <td>
                            <label for="accountName"><?= \Yii::t('app', 'Account Name'); ?></label>
                            <?= 
                                Html::activeTextInput($model, 'accountName', [
                                    'class' => 'text-input small',
                                    'id' => 'accountName'
                                ]);
                            ?>
                            <?= Html::error($model, 'accountName', ['class' => 'error-message']) ?>
                        </td>
                        <td>
                            <label for="companyName"><?= \Yii::t('app', 'Company Name'); ?></label>
                            <?= 
                                Html::activeTextInput($model, 'companyName', [
                                    'class' => 'text-input small',
                                    'id' => 'companyName'
                                ]);
                            ?>
                            <?= Html::error($model, 'companyName', ['class' => 'error-message']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="email"><?= \Yii::t('app', 'Email'); ?></label>
                            <?= 
                                Html::activeTextInput($model, 'email', [
                                    'class' => 'text-input small',
                                    'id' => 'email'
                                ]);
                            ?>
                            <?= Html::error($model, 'email', ['class' => 'error-message']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="address1"><?= \Yii::t('app', 'Address'); ?> <span class="gray-text"> (<?= \Yii::t('app', 'Line'); ?> 1)</span></label>
                            <?= 
                                Html::activeTextInput($model, 'address1', [
                                    'class' => 'text-input small',
                                    'id' => 'address1'
                                ]);
                            ?>
                            <?= Html::error($model, 'address1', ['class' => 'error-message']) ?>
                        </td>
                        <td>
                            <label for="address2"><?= \Yii::t('app', 'Address'); ?><span class="gray-text"> (<?= \Yii::t('app', 'Line'); ?> 2)</span></label>
                            <?= 
                                Html::activeTextInput($model, 'address2', [
                                    'class' => 'text-input small',
                                    'id' => 'address2'
                                ]);
                            ?>
                            <?= Html::error($model, 'address2', ['class' => 'error-message']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="suburb"><?= \Yii::t('app', 'Suburb'); ?></label>
                            <?= 
                                Html::activeTextInput($model, 'suburb', [
                                    'class' => 'text-input small',
                                    'id' => 'suburb'
                                ]);
                            ?>
                            <?= Html::error($model, 'suburb', ['class' => 'error-message']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="countryId"><?= \Yii::t('app', 'Country'); ?></label>
                            <?= 
                                Html::activeDropDownList($model, 'countryId', $model->getCountryArrayMap(), [
                                    'id' => 'countryId',
                                    'class' => 'j_select select-218'
                                ]); 
                            ?>
                            <?= Html::error($model, 'countryId', ['class' => 'error-message']) ?>
                        </td>
                        <td>
                            <label for="stateId"><?= \Yii::t('app', 'State'); ?></label>
                            <?= 
                                Html::activeDropDownList($model, 'stateId', $model->getStateArrayMap(), [
                                    'id' => 'stateId',
                                    'class' => 'j_select select-218'
                                ]); 
                            ?>
                            <?= Html::error($model, 'stateId', ['class' => 'error-message']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="postcode"><?= \Yii::t('app', 'Postcode'); ?></label>
                            <?= 
                                Html::activeTextInput($model, 'postcode', [
                                    'class' => 'text-input small',
                                    'id' => 'postcode'
                                ]);
                            ?>
                            <?= Html::error($model, 'postcode', ['class' => 'error-message']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="phone"><?= \Yii::t('app', 'Phone'); ?></label>
                            <?= 
                                Html::activeTextInput($model, 'phone', [
                                    'class' => 'text-input small',
                                    'id' => 'phone'
                                ]);
                            ?>
                            <?= Html::error($model, 'phone', ['class' => 'error-message']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="timeZoneId"><?= \Yii::t('app', 'Timezone'); ?></label>
                            <?= 
                                Html::activeDropDownList($model, 'timeZoneId', $model->getTimeZoneArrayMap(), [
                                    'id' => 'timeZoneId',
                                    'class' => 'j_select select-218'
                                ]); 
                            ?>
                            <?= Html::error($model, 'timeZoneId', ['class' => 'error-message']) ?>
                        </td>
                        <td>
                            <label for="timeFormatId"><?= \Yii::t('app', 'Time Format'); ?></label>
                            <?= 
                                Html::activeDropDownList($model, 'timeFormatId', $model->getTimeFormatArrayMap(), [
                                    'id' => 'timeFormatId',
                                    'class' => 'j_select select-218'
                                ]); 
                            ?>
                            <?= Html::error($model, 'timeFormat', ['class' => 'error-message']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="currencyId"><?= \Yii::t('app', 'Account currency'); ?></label>
                            <?= 
                                Html::activeDropDownList($model, 'currencyId', $model->getCurrencyArrayMap(), [
                                    'id' => 'currencyId',
                                    'class' => 'j_select select-218'
                                ]); 
                            ?>
                            <?= Html::error($model, 'currencyId', ['class' => 'error-message']) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="border-top-block">
                <?= Html::submitButton(\Yii::t('app', 'Save Settings'), ['class' => 'btn blue']); ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>