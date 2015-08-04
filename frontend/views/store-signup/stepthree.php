<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model frontend\models\StoreSignupForm
 */
$this->title = \Yii::t('app', 'Step 3 - Store Owner Signup');



$options = ['options' => ['class' => '']];
$wholerow = ['options' => ['class' => '']];
?>



<h2 class="center">Few steps to start using Yello</h2>

<div class="gray-text center">Lorem ipsum dolor sit amet, consectetur adipscing elit.<br>Maecenas ut tellus est. Donec ut eros magna.
</div>
<center>
    <div style="max-width:700px;border:1px solid #bcc0c1; border-radius:6px;position:relative;margin-top:30px;text-align: left;">

        
            <div class="create-header">
                <div class="step-list">
                    <div class="step-item complete"><span>1</span>Company Details
                    </div>
                    <div class="step-item complete"><span>2</span>Payment Details
                    </div>
                    <div class="step-item active"><span>3</span>Create first Store
                    </div>
                </div>
            </div>        
        
        <?php
        $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'id' => 'store-signup-step-three',
                    'options' => ['role'=>'form','autocomplete'=>'off','onsubmit'=>'return false'],
                    'fieldConfig' => [
                        'template' => '<div class="">{label}{input}{error}</div>',
                        'options' =>['autocomplete'=>'false'],
                        'horizontalCssClasses' => [
                            'error' => 'error-message',
                            'label' => '',
                            'placeholder' => ''
                        ]
                    ],
        ]);
        ?>
        <div class="create-body">
            <div class="row" style="margin-top:30px;">
                <div class="col col-md-6 col-lg-6">
                    <div class="col col-md-10">
                        <h3>Store Details</h3>
                        <div class="gray-text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut tellus est. Donec ut eros magna.</p></div>
                        <div class="help-block help-block-error error-message payment-errors"></div>
                    </div>
                </div>
                <div class="col col-md-6 col-lg-6">
                   


                </div>
            </div>
        </div>

                    <hr style="width:90%;margin:30px;">


                    <div class="create-body">
                        <div class="row">
                            <div class="col col-md-6 col-lg-6">
                                <div class="col col-md-10">
                                <h3>Store Address</h3>
                                <div class="gray-text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut tellus est. Donec ut eros magna.</p></div>
                                <div class="help-block help-block-error error-message" id="address-errors"></div>
                                </div>
                            </div>
                            <div class="col col-md-6 col-lg-6" id="address">
                                <input autocomplete="false" name="hidden" type="text" style="display:none;"> 

                                    <?= \frontend\widgets\Address\AddressWidget::widget(['name' => 'formatted_address', 'formName' => 'store-signup-step-three', 'fieldsMapping' => [
                                        'subpremise' => 'long_name',
                                        'street_number' => 'short_name',
                                        'route' => 'long_name',
                                        'locality' => 'long_name',
                                        'administrative_area_level_1' => 'short_name',
                                        'country' => 'long_name',
                                        'postal_code' => 'short_name'
                                    ]]); ?>

                                
                                    <?php echo $form->field($model, 'block_or_unit',['inputOptions'=>['class'=>'form-control','placeholder'=>'Unit','disabled'=>'true'],'options'=>['class'=>'col col-sm-6 col-md-2 col-lg-2','style'=>'padding-left:0;padding-right:0;']]); ?>
                                    <?php echo $form->field($model, 'street_number',['inputOptions'=>['class'=>'form-control','placeholder'=>'St #','disabled'=>'true'],'options'=>['class'=>'col col-sm-6 col-md-2 col-lg-2','style'=>'padding-left:0;padding-right:0;']  ]); ?>
                                    <?php echo $form->field($model, 'route',['inputOptions'=>['class'=>'form-control','placeholder'=>'Street','disabled'=>'true'],'options'=>['class'=>'col col-sm-12 col-md-8 col-lg-8','style'=>'padding-left:0;padding-right:5px;']]); ?>
                                    <?php echo $form->field($model, 'locality',['inputOptions'=>['class'=>'form-control','disabled'=>'true'] ,'options'=>['class'=>'col col-sm-12 col-md-8 col-lg-8','style'=>'padding-left:0;padding-right:5px;'] ]); ?>
                                    <?php echo $form->field($model, 'administrative_area_level_1',['inputOptions'=>['class'=>'form-control','disabled'=>'true'],'options'=>['class'=>'col col-sm-6 col-md-4 col-lg-4 ','style'=>'padding-left:0;padding-right:0px;']]); ?>
                                    <?php echo $form->field($model, 'postal_code',['inputOptions'=>['class'=>'form-control stripeform','disabled'=>'true'],'options'=>['class'=>'col col-sm-6 col-md-4 col-lg-3 ','style'=>'padding-left:0;padding-right:5px;']]); ?>
                                    <?php echo $form->field($model, 'country',['inputOptions'=>['class'=>'form-control','disabled'=>'true'],'options'=>['class'=>'col col-sm-6 col-md-8 col-lg-9 ','style'=>'padding-left:0;padding-right:0px;']]); ?>       
                            </div>
                        </div>
                    </div>
                                 
                    


        <div class="create-footer text-right" style="margin-top:30px;">
            <?= Html::submitButton(\Yii::t('app', 'Next Step'), ['class' => 'btn blue uppercase disableme','data-disabledmsg'=>'Saving...','data-enabledmsg'=>'Next Step']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>      


</center>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>