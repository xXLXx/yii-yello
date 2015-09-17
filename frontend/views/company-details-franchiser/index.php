<?php

use frontend\widgets\SettingsLeftNavigation;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * $this yii\web\View
 * $model frontend\models\FranchiserCompanyForm
 */
$this->title = \Yii::t('app', 'Company Details');
?>

<div class="sidebar-container">

    <?= SettingsLeftNavigation::widget(); ?>

    <div class="col-right">

        <h2><?= $this->title ?></h2>

        <?php $form = ActiveForm::begin([
            'id' => 'company-details-franchiser',
            'layout' => 'horizontal',
            'options' => [
                'enctype' => 'multipart/form-data',
            ],
        ]); ?>

        <?= Html::activeHiddenInput($model, 'id'); ?>

        <div class="clearfix">
            <table class="profile-settings">
                <tr>
                    <td colspan="2">
                        <label for="companyName"><?= Yii::t('app', 'Company Name'); ?></label>
                        <?= Html::activeTextInput($model, 'companyName', [
                            'id' => 'companyName',
                            'class' => 'text-input small',
                        ]); ?>
                        <?= Html::error($model, 'companyName', ['class' => 'error-message']); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email"><?= Yii::t('app', 'Email'); ?></label>
                        <?= Html::activeTextInput($model, 'email', [
                            'id' => 'email',
                            'class' => 'text-input small',
                        ]); ?>
                        <?= Html::error($model, 'email', ['class' => 'error-message']); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="address1"><?= Yii::t('app', 'Address'); ?> <span class="gray-text"> (<?= Yii::t('app', 'Line'); ?> 1)</span></label>
                        <?= Html::activeTextInput($model, 'address1', [
                            'class' => 'text-input small',
                            'id' => 'address1'
                        ]); ?>
                        <?= Html::error($model, 'address1', ['class' => 'error-message']); ?>
                    </td>
                    <td>
                        <label for="address2"><?= Yii::t('app', 'Address'); ?><span class="gray-text"> (<?= Yii::t('app', 'Line'); ?> 2)</span></label>
                        <?= Html::activeTextInput($model, 'address2', [
                            'class' => 'text-input small',
                            'id' => 'address2'
                        ]); ?>
                        <?= Html::error($model, 'address2', ['class' => 'error-message']); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="suburb"><?= Yii::t('app', 'Suburb'); ?></label>
                        <?= Html::activeTextInput($model, 'suburb', [
                            'class' => 'text-input small',
                            'id' => 'suburb'
                        ]); ?>
                        <?= Html::error($model, 'suburb', ['class' => 'error-message']); ?>
                    </td>
                    <td>
                        <label for="stateId"><?= Yii::t('app', 'State'); ?></label>
                        <?= Html::activeDropDownList($model, 'stateId', $model->getStateArrayMap(), [
                            'id' => 'stateId',
                            'class' => 'j_select select-218'
                        ]); ?>
                        <?= Html::error($model, 'stateId', ['class' => 'error-message']) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="contact-person"><?= Yii::t('app', 'Contact Person'); ?></label>
                        <?= Html::activeTextInput($model, 'contactPerson', [
                            'id' => 'contact-person',
                            'class' => 'text-input small',
                        ]); ?>
                        <?= Html::error($model, 'contactPerson', ['class' => 'error-message']); ?>
                    </td>
                    <td>
                        <label for="phone"><?= \Yii::t('app', 'Phone'); ?></label>
                        <?= Html::activeTextInput($model, 'phone', [
                            'class' => 'text-input small',
                            'id' => 'phone'
                        ]); ?>
                        <?= Html::error($model, 'phone', ['class' => 'error-message']); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="website"><?= Yii::t('app', 'Website'); ?></label>
                        <?= Html::activeTextInput($model, 'website', [
                            'id' => 'website',
                            'class' => 'text-input small',
                        ]); ?>
                        <?= Html::error($model, 'website', ['class' => 'error-message']); ?>
                    </td>
                    <td>
                        <label for="abn">ABN</label>
                        <?= Html::activeTextInput($model, 'ABN', [
                            'id' => 'abn',
                            'class' => 'text-input small',
                        ]); ?>
                        <?= Html::error($model, 'ABN', ['class' => 'error-message']); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="timeZoneId"><?= \Yii::t('app', 'Timezone'); ?></label>
                        <?= Html::activeDropDownList($model, 'timeZoneId', $model->getTimeZoneArrayMap(), [
                            'id' => 'timeZoneId',
                            'class' => 'j_select select-218'
                        ]); ?>
                        <?= Html::error($model, 'timeZoneId', ['class' => 'error-message']) ?>
                    </td>
                    <td>
                        <label for="format"><?= \Yii::t('app', 'Time Format'); ?></label>
                        <?= Html::activeDropDownList($model, 'timeFormatId', $model->getTimeFormatArrayMap(), [
                            'id' => 'format',
                            'class' => 'j_select select-218'
                        ]); ?>
                        <?= Html::error($model, 'timeFormat', ['class' => 'error-message']) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="currency"><?= \Yii::t('app', 'Account currency'); ?></label>
                        <?= Html::activeDropDownList($model, 'currencyId', $model->getCurrencyArrayMap(), [
                            'id' => 'currency',
                            'class' => 'j_select select-218'
                        ]); ?>
                        <?= Html::error($model, 'currencyId', ['class' => 'error-message']) ?>
                    </td>
                </tr>
            </table>
            <div class="company-logo">
                <div class="company-logo-container no-photo f-left">
                    <img src="/images/profile-thumb/<?= $model->id; ?>" class="j_image-file-destination"   onError="this.onerror=null;this.src='/img/Driver_Pic_bgrey_black.png';" >
                </div>
                <div class="company-info">
                    <h5><?= Yii::t('app', 'Logo'); ?></h5>
                    <div class="gray-text">Recommended use square image with minimal dimensions 276x276px.<br>*.png, *.jpeg, *.gif</div>
                    <div class="upload-file">
                        <div class="link-icon font-picture-streamline blue-text"><?= Yii::t('app', 'Upload logo'); ?></div>
                        <?= Html::activeFileInput($model, 'imageFile', [
                            'class' => 'j_image-file-input',
                            'id'    => 'image'
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-top-block">
            <?= Html::resetButton(\Yii::t('app', 'Cancel'), ['class' => 'btn']); ?>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn blue']); ?>
        </div>

        <?php ActiveForm::end(); ?>
        <?php $this->registerJs('ImageUploadPreview.init();'); ?>
    </div>
</div>

