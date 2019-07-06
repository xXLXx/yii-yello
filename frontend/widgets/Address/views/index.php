<?php use \yii\helpers\Html; ?>

<div class="row">
    
    <div class="form-group col-sm-12">
        <?= Html::textInput($name, null, $options); ?>
    </div>
    <?php // this will prevent chrome from overlaying with autofill ?>
    <input autocomplete="false" name="hidden" type="text" style="display:none;"> 
    <?= $form->field($model, 'block_or_unit',['options'=>['class'=>'form-group col-sm-2'], 'inputOptions' => ['readonly' => true]])->label(false); ?>
    <?= $form->field($model, 'street_number',['options'=>['class'=>'form-group col-sm-3'], 'inputOptions' => ['readonly' => true]])->label(false); ?>
    <?= $form->field($model, 'route',['options'=>['class'=>'form-group col-sm-7'], 'inputOptions' => ['readonly' => true]])->label(false); ?>
    <?= $form->field($model, 'locality',['options'=>['class'=>'form-group col-sm-8'], 'inputOptions' => ['readonly' => true]]); ?>
    <?= $form->field($model, 'administrative_area_level_1',['options'=>['class'=>'form-group col-sm-4'], 'inputOptions' => ['readonly' => true]]); ?>
    <?= $form->field($model, 'postal_code',['options'=>['class'=>'form-group col-sm-4'], 'inputOptions' => ['readonly' => true]]); ?>
    <?= $form->field($model, 'country',['options'=>['class'=>'form-group col-sm-8'], 'inputOptions' => ['readonly' => true]]); ?>

    <?= Html::activeHiddenInput($model, 'latitude'); ?>
    <?= Html::activeHiddenInput($model, 'formatted_address'); ?>
    <?= Html::activeHiddenInput($model, 'longitude'); ?>
    <?= Html::activeHiddenInput($model, 'googleplaceid'); ?>
    <?= Html::activeHiddenInput($model, 'googleobj'); ?>
    <?= Html::activeHiddenInput($model, 'utcOffset'); ?>
    <?= Html::activeHiddenInput($model, 'timezone'); ?>
</div>