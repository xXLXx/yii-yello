<?php
use frontend\widgets\SettingsLeftNavigation;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = $model->id ? \Yii::t('app', 'Edit Store') : \Yii::t('app', 'Add New Store');
?>

<div class="sidebar-container">
    <?= SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <h2><?= $this->title ?></h2>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= \yii\helpers\Html::activeHiddenInput($model, 'id'); ?>
        <div class="row">
            <div class="col-md-8">
                <fieldset>
                    <?php echo $form->field($model, 'title'); ?>
                </fieldset>
                <fieldset>
                    <div class="form-group">
                        <?= \frontend\widgets\Address\AddressWidget::widget(['name' => 'test', 'formName' => 'storeform', 'fieldsMapping' => [
                            'subpremise' => 'long_name',
                            'street_number' => 'short_name',
                            'route' => 'long_name',
                            'locality' => 'long_name',
                            'administrative_area_level_1' => 'short_name',
                            'country' => 'long_name',
                            'postal_code' => 'short_name'
                        ]]); ?>
                        <?php echo Html::activeHiddenInput($model, 'formatted_address'); ?>
                        <?php echo Html::activeHiddenInput($model, 'latitude'); ?>
                        <?php echo Html::activeHiddenInput($model, 'longitude'); ?>
                        <?php echo Html::activeHiddenInput($model, 'googleplaceid'); ?>
                        <?php echo Html::activeHiddenInput($model, 'googleobj'); ?>

                                    <?php echo $form->field($model, 'block_or_unit',['inputOptions'=>['class'=>'form-control','placeholder'=>'Unit','disabled'=>'true'],'options'=>['class'=>'col col-sm-6 col-md-2 col-lg-2','style'=>'padding-left:0;padding-right:0;']])->label('Street'); ?>
                                    <?php echo $form->field($model, 'street_number',['inputOptions'=>['class'=>'form-control','placeholder'=>'St #','disabled'=>'true'],'options'=>['class'=>'col col-sm-6 col-md-2 col-lg-2','style'=>'padding-left:0;padding-right:0;']  ])->label('&nbsp;'); ?>
                                    <?php echo $form->field($model, 'route',['inputOptions'=>['class'=>'form-control','placeholder'=>'Street name','disabled'=>'true'],'options'=>['class'=>'col col-sm-12 col-md-8 col-lg-8','style'=>'padding-left:0;padding-right:5px;']])->label('&nbsp;'); ?>
                                    <?php echo $form->field($model, 'locality',['inputOptions'=>['class'=>'form-control','disabled'=>'true'] ,'options'=>['class'=>'col col-sm-12 col-md-8 col-lg-8','style'=>'padding-left:0;padding-right:5px;'] ]); ?>
                                    <?php echo $form->field($model, 'administrative_area_level_1',['inputOptions'=>['class'=>'form-control','disabled'=>'true'],'options'=>['class'=>'col col-sm-6 col-md-4 col-lg-4 ','style'=>'padding-left:0;padding-right:0px;']]); ?>
                                    <?php echo $form->field($model, 'postal_code',['inputOptions'=>['class'=>'form-control stripeform','disabled'=>'true'],'options'=>['class'=>'col col-sm-6 col-md-4 col-lg-3 ','style'=>'padding-left:0;padding-right:5px;']]); ?>
                                    <?php echo $form->field($model, 'country',['inputOptions'=>['class'=>'form-control','disabled'=>'true'],'options'=>['class'=>'col col-sm-6 col-md-8 col-lg-9 ','style'=>'padding-left:0;padding-right:0px;']]); ?>     


                    </div>
                  
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
                </fieldset>
            </div>
            <div class="col-md-4">
                <div class="user-photo-container">
                    <img class="j_image-file-destination" src="<?= $model->image ? $model->image->thumbUrl : '/img/store_image.svg' ?>"/>
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