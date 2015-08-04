<?php
use frontend\widgets\SettingsLeftNavigation;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = \Yii::t('app', 'Add New Store');
?>

<div class="sidebar-container">
    <?= SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <h2><?= $this->title ?></h2>
        <?php $form = ActiveForm::begin(); ?>
        <?= \yii\helpers\Html::activeHiddenInput($model, 'id'); ?>
        <div class="row">
            <div class="col-md-8">
                <fieldset>
                    <?php echo $form->field($model, 'title'); ?>
                </fieldset>
                <fieldset>
                    <div class="form-group">
                        <?= \frontend\widgets\Address\AddressWidget::widget(['name' => 'test', 'formName' => 'storeform', 'fieldsMapping' => [
                            'street_number' => 'short_name',
                            'route' => 'long_name',
                            'locality' => 'long_name',
                            'administrative_area_level_1' => 'short_name',
                            'country' => 'long_name',
                            'postal_code' => 'short_name'
                        ]]); ?>
                    </div>
                    <div class="row">
                        <?= $form->field($model, 'street_number',['options'=>['class'=>'form-group col-sm-12 col-md-6']])->label(false); ?>
                        <?= $form->field($model, 'route',['options'=>['class'=>'form-group col-sm-12 col-md-6']])->label(false); ?>
                    </div>
                    <div class="row">
                        <?= $form->field($model, 'locality',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                        <?= $form->field($model, 'administrative_area_level_1',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                    </div>
                    <div class="row">
                        <?= $form->field($model, 'postal_code',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                        <?= $form->field($model, 'country',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                    </div>
                    <div class="row">
                        <?= $form->field($model, 'contactPerson',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                        <?= $form->field($model, 'phone',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                    </div>
                    <div class="row">
                        <?= $form->field($model, 'businessTypeId',['options'=>['class'=>'form-group col-sm-12 col-md-6']])
                                ->dropDownList(\common\models\BusinessType::find()->select(['title', 'id'])->indexBy('id')->column(),
                                    ['prompt' => 'Select business type ...']); ?>
                        <?= $form->field($model, 'abn',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                    </div>
                    <div class="row">
                        <?= $form->field($model, 'website',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                        <?= $form->field($model, 'email',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                    </div>
                    <div class="row">
                        <?= $form->field($model, 'businessHours',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                        <?= $form->field($model, 'storeProfile',['options'=>['class'=>'form-group col-sm-12 col-md-6']]); ?>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-4">
                <div class="user-photo-container">
                    <img class="j_image-file-destination" src="<?= $model->image ? $model->image->thumbUrl : '/img/temp/07.png' ?>"/>
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
            <?= Html::submitButton($submitName, ['class' => 'btn blue']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>