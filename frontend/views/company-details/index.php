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
        <div class="row">
            <?php echo $form->field($model, 'accountName', $options); ?>
            <?php echo $form->field($model, 'companyName', $options); ?>
            <?php echo $form->field($model, 'ABN', $options); ?>
        </div>

        <div class="row">
            <?php echo $form->field($model, 'contact_name', $options); ?>
            <?php echo $form->field($model, 'contact_phone', $options); ?>
            <?php echo $form->field($model, 'contact_email', $options); ?>
        </div>

        <?= \frontend\widgets\Address\AddressWidget::widget(['model' => $model, 'form' => $form]); ?>

        <div class="border-top-block col col-lg-10">
            <?= Html::submitButton(\Yii::t('app', 'Save Settings'), ['class' => 'btn blue']); ?>
        </div>
            

        <?php ActiveForm::end(); ?>
    </div>
</div>