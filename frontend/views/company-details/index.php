<?php

use frontend\widgets\SettingsLeftNavigation;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model frontend\models\CompanyForm
 */
$this->title = \Yii::t('app', 'Company Details');




$options = ['options'=>['class'=>'form-group col-sm-12 col-md-6 col-lg-6']];
$wholerow = ['options'=>['class'=>'col col-sm-11 col-md-10 col-lg-10']];
?>

<div class="sidebar-container">
    <?= SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <h2><?= $this->title ?></h2>
        <?php $form = ActiveForm::begin(); ?>
        <?= Html::activeHiddenInput($model, 'id'); ?>
        <fieldset>
            <?php echo $form->field($model, 'accountName', $options); ?>
            <?php echo $form->field($model, 'companyName', $options); ?>
            <?php echo $form->field($model, 'ABN', $options); ?>
        </fieldset>

        <fieldset>
            <?php echo $form->field($model, 'contact_name', $options); ?>
            <?php echo $form->field($model, 'contact_phone', $options); ?>
            <?php echo $form->field($model, 'contact_email', $options); ?>
        </fieldset>

        <fieldset>
            <div class="form-group col-md-12">
                <?= \frontend\widgets\Address\AddressWidget::widget(['name' => 'test', 'formName' => 'companyform', 'fieldsMapping' => [
                    'street_number' => 'short_name',
                    'route' => 'long_name',
                    'locality' => 'long_name',
                    'administrative_area_level_1' => 'short_name',
                    'country' => 'long_name',
                    'postal_code' => 'short_name'
                ]]); ?>
            </div>
            <?php echo $form->field($model, 'street_number',['options'=>['class'=>'form-group col-sm-3']]); ?>
            <?php echo $form->field($model, 'route',['options'=>['class'=>'form-group col-sm-9']]); ?>
            <?php echo $form->field($model, 'locality',['options'=>['class'=>'form-group col-sm-8']]); ?>
            <?php echo $form->field($model, 'administrative_area_level_1',['options'=>['class'=>'form-group col-sm-4']]); ?>
            <?php echo $form->field($model, 'postal_code',['options'=>['class'=>'form-group col-sm-4']]); ?>
            <?php echo $form->field($model, 'country',['options'=>['class'=>'form-group col-sm-8']]); ?>

            <?= Html::activeHiddenInput($model, 'latitude'); ?>
            <?= Html::activeHiddenInput($model, 'longitude'); ?>
        </fieldset>

        <div class="border-top-block col col-lg-10">
            <?= Html::submitButton(\Yii::t('app', 'Save Settings'), ['class' => 'btn blue']); ?>
        </div>
            

        <?php ActiveForm::end(); ?>
    </div>
</div>