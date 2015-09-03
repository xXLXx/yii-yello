<?php
use frontend\widgets\SettingsLeftNavigation;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = $model->id ? \Yii::t('app', 'Edit Store') : \Yii::t('app', 'Add New Store');

$this->registerJsFile('/js/ImageUploadPreview.js');
$this->registerJs('ImageUploadPreview.init();');
?>

<div class="sidebar-container">
    <?= SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <h2><?= $this->title ?></h2>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= \yii\helpers\Html::activeHiddenInput($model, 'id'); ?>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <?= $form->field($model, 'title',['options' => ['class' => 'form-group col-sm-12']]); ?>
                </div>

                <?= \frontend\widgets\Address\AddressWidget::widget(['model' => $model, 'form' => $form]); ?>

                <div class="row">
                    <?= $form->field($model, 'contact_name',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                    <?= $form->field($model, 'contact_phone',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'contact_email',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                    <?= $form->field($model, 'website',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'businessTypeId',['options'=>['class'=>'form-group col-sm-12 col-md-6']])
                        ->dropDownList(\common\models\BusinessType::find()->select(['title', 'id'])->indexBy('id')->column(),
                            ['prompt' => 'Select business type ...']); ?>
                    <?= $form->field($model, 'companyId',['options'=>['class'=>'form-group col-sm-12 col-md-6']])
                        ->dropDownList(\common\models\Company::find()->select(['companyName', 'id'])->where(['userfk'=>$model->ownerid])->indexBy('id')->column()); ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'businessHours',['options'=>['class'=>'form-group col-sm-12 col-md-6']])->textarea(); ?>
                    <?= $form->field($model, 'storeProfile',['options'=>['class'=>'form-group col-sm-12 col-md-6']])->textarea(); ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="user-photo-container">
                    <img class="j_image-file-destination" src="/img/store_image.png"/>
                </div>
                <div class="upload-file">
                    <div class="blue-text">Upload logo</div>
                    <?=
                    Html::activeFileInput($model, 'imageFile', [
                        'class' => 'j_image-file-input',
                        'id'    => 'image'
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="border-top-block">
            <?= Html::a(\Yii::t('app', 'Cancel'), ['your-stores/index'], ['class' => 'btn white'])?>
            <?php $submitName = $model->id ? \Yii::t('app', 'Save') : \Yii::t('app', 'Add Store');?>
            <?= Html::submitButton($submitName, ['class' => 'btn blue disableme']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>