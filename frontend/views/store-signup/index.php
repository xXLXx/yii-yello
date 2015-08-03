<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model frontend\models\StoreSignupForm
 */
$this->title = \Yii::t('app', 'Store Owner Signup');

?>

       

<h2 class="center">Few steps to start using Yello</h2>

<div class="gray-text center">Lorem ipsum dolor sit amet, consectetur adipscing elit.<br>Maecenas ut tellus est. Donec ut eros magna.
        </div>
<center>
                <div style="max-width:700px;border:1px solid #bcc0c1; border-radius:6px;position:relative;margin-top:30px;text-align: left;">

                    <div class="create-header" style="background:#f6f6f6;">
                        <div class="step-list">
                            <div class="step-item active"><span>1</span>Company Details</div>
                            <div class="step-item"><span>2</span>Payment Details</div>
                            <div class="step-item"><span>3</span>Create first Store</div>
                        </div>
                    </div>
                    <?php
                        $form = ActiveForm::begin([
                            'fieldConfig' => [
                                'wrapperOptions' => [
                                    'class' => 'form-group',
                                ]
                            ]
                        ]);
                     ?>
                     <?= Html::activeHiddenInput($model, 'id'); ?>
                    <div class="create-body">
                        <div class="row" style="margin-top:30px;">
                            <div class="col col-md-6 col-lg-6">
                                <div class="col col-md-10">
                                <h3>Contact Details</h3>
                                <div class="gray-text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut tellus est. Donec ut eros magna.</p></div>
                                </div>
                            </div>
                            <div class="col col-md-6 col-lg-6">
                                <?php echo $form->field($model, 'companyname'); ?>
                                <?php echo $form->field($model, 'abn'); ?>
                                <?php echo $form->field($model, 'contact_phone'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <hr style="width:90%;margin:30px;">

                    <div class="create-body">
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                <h3>Address</h3>
                                <div class="gray-text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut tellus est. Donec ut eros magna.</p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <?= \frontend\widgets\Address\AddressWidget::widget(['name' => 'test', 'formName' => 'storesignupform', 'fieldsMapping' => [
                                        'street_number' => 'short_name',
                                        'route' => 'long_name',
                                        'locality' => 'long_name',
                                        'administrative_area_level_1' => 'short_name',
                                        'country' => 'long_name',
                                        'postal_code' => 'short_name'
                                    ]]); ?>
                                </div>
                                <?php echo $form->field($model, 'block_or_unit', [
                                    'inputOptions' => [
                                        'placeHolder' => 'Floor and/or Unit'
                                    ]
                                ])->label(false) ?>
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <?= $form->field($model, 'street_number')->label(false); ?>
                                    </div>
                                    <div class="col-sm-12 col-md-9">
                                        <?= $form->field($model, 'route')->label(false); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-8">
                                        <?= $form->field($model, 'locality'); ?>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <?= $form->field($model, 'administrative_area_level_1'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <?= $form->field($model, 'postal_code'); ?>
                                    </div>
                                    <div class="col-sm-12 col-md-8">
                                        <?= $form->field($model, 'country'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                        
                    
                    
                    <div class="create-footer text-right" style="margin-top:30px;">
                        <?= Html::submitButton(\Yii::t('app', 'Next Step'), ['class' => 'btn blue uppercase disableme']); ?>
                    </div>
        <?php ActiveForm::end(); ?>
                </div>      
</center>