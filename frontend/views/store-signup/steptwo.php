<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\StoreSignupStepTwoAsset;

/**
 * @var $this yii\web\View
 * @var $model frontend\models\StoreSignupForm
 */
$this->title = \Yii::t('app', 'Step 2 - Store Owner Signup');

StoreSignupStepTwoAsset::register($this);


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
                <div class="step-item complete"><span>1</span>Company Details</div>
                <div class="step-item active"><span>2</span>Payment Details</div>
                <div class="step-item"><span>3</span>Create first Store</div>
            </div>
        </div>
        <?php
        $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'id' => 'store-signup-step-two',
                    'enableClientValidation' => false,
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
        <?php echo Html::activeHiddenInput($model, 'companyId'); ?>
        <div class="create-body">
            <div class="row" style="margin-top:30px;">
                <div class="col col-md-6 col-lg-6">
                    <div class="col col-md-10">
                        <h3>Card Details</h3>
                        <div class="gray-text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut tellus est. Donec ut eros magna.</p></div>
                        <div class="help-block help-block-error error-message payment-errors"></div>
                    </div>
                </div>
                <div class="col col-md-6 col-lg-6">
                    <div class="">
                        <div class=""><label class="control-label ">Cardholder Name</label><input type="text" class="form-control" data-stripe="name" >
                            <div class="help-block help-block-error error-message"></div>
                        </div>
                    </div>                                
                    <div class="">
                        <div class="">
                            <label class="control-label ">Card Number</label>
                            <input type="text" class="form-control" data-stripe="number" >
                        </div>
                    </div>

                    <div class="">
                        <div class="col col-lg-6 col-md-6 col-sm-7" style="margin-left: 0;margin-right: 0;padding-left: 0;">
                            <label class="control-label ">Expires</label><div class="clearfix"></div>
                            <input type="text" class="form-control" style="width: 60px; display: inline-block;" data-stripe="exp-month" placeholder="MM" >
                            <input type="text" class="form-control" style="width: 60px; display: inline-block;" data-stripe="exp-year" placeholder="YYYY" >
                        </div>
                        <div class="col col-lg-5 col-md-5 col-sm-3" style="margin-left: 10px;margin-right: 0;padding-left: 0;">
                            <label class="control-label ">CVC</label><div class="clearfix"></div>
                            <input type="text" class="form-control" style="width: 60px; display: inline-block;" data-stripe="cvc" >
                        </div>
                    </div>


                </div>
            </div>
        </div>

                    <hr style="width:90%;margin:30px;">


                    <div class="create-body">
                        <div class="row">
                            <div class="col col-md-6 col-lg-6">
                                <div class="col col-md-10">
                                <h3>Billing Address</h3>
                                <div class="gray-text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut tellus est. Donec ut eros magna.</p></div>
                                <div class="help-block help-block-error error-message" id="address-errors"></div>
                                </div>
                            </div>
                            <div class="col col-md-6 col-lg-6" id="address">
                                <input autocomplete="false" name="hidden" type="text" style="display:none;">

                                <input class="form-control" id="autocomplete" placeholder="Enter your billing address here" autocomplete="off" onfocus="geolocatestripe()" type="text">

                                    <?php echo $form->field($model, 'address_line1',['inputOptions'=>['data-stripe'=>'address_line1','class'=>'form-control stripeform']]); ?>
                                    <?php echo $form->field($model, 'address_line2',['inputOptions'=>['data-stripe'=>'address_line2','class'=>'form-control stripeform']  ]); ?>
                                    <?php echo $form->field($model, 'address_city',['inputOptions'=>['data-stripe'=>'address_city','class'=>'form-control stripeform'],'options'=>['class'=>'col col-sm-12 col-md-8 col-lg-8','style'=>'padding-left:0;padding-right:5px;']]); ?>
                                    <?php echo $form->field($model, 'address_state',['inputOptions'=>['data-stripe'=>'address_state','class'=>'form-control stripeform'],'options'=>['class'=>'col col-sm-6 col-md-4 col-lg-4 ','style'=>'padding-left:0;padding-right:0px;']]); ?>
                                    <?php echo $form->field($model, 'address_zip',['inputOptions'=>['data-stripe'=>'address_zip','class'=>'form-control stripeform'],'options'=>['class'=>'col col-sm-6 col-md-4 col-lg-3 ','style'=>'padding-left:0;padding-right:5px;']]); ?>
                                    <?php echo $form->field($model, 'address_country',['inputOptions'=>['data-stripe'=>'address_country','class'=>'form-control stripeform'],'options'=>['class'=>'col col-sm-6 col-md-8 col-lg-9 ','style'=>'padding-left:0;padding-right:0px;']]); ?>

                            </div>
                        </div>
                    </div>
                                 
                    


        <div class="create-footer text-right" style="margin-top:30px;">
            <?= Html::button(\Yii::t('app', 'Next Step'), ['id' => 'btn-submit', 'class' => 'btn blue uppercase disableme','data-disabledmsg'=>'Saving...','data-enabledmsg'=>'Next Step']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>      


</center>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
