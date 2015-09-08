<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model frontend\models\StoreSignupForm
 */
$this->title = \Yii::t('app', 'Step 3 - Store Owner Signup');

$this->registerJsFile('/js/ImageUploadPreview.js');
$this->registerJs('ImageUploadPreview.init();');

?>



<h2 class="center">Your first store details</h2>

<center>
    <div class="gray-text center" style="max-width:700px;">To open up your account we need some details about your first store. Once you account is created you will have the opportunity to create additional stores.</div>
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
                    'id' => 'store-signup-step-three',
                    'options' => ['role'=>'form','autocomplete'=>'off', 'enctype' => 'multipart/form-data'],
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
                        <h3>Store Details</h3>
                        <div class="gray-text"><p>Please provide the name of your first store (e.g. Crust Pizza Double Bay) and the type of business it is.</p></div>
                        <div class="help-block help-block-error error-message payment-errors"></div>
                    </div>
                </div>
                <div class="col col-md-6 col-lg-6">
                                <?php echo $form->field($model, 'storename'); ?>
                                <?= $form->field($model, 'businessTypeId',['options'=>['class'=>'form-group']])
                                ->dropDownList(\common\models\BusinessType::find()->select(['title', 'id'])->indexBy('id')->column(),
                                    ['prompt' => 'Select business type ...']); ?>

                </div>
            </div>
        </div>

                    <hr style="width:90%;margin:30px;">


        <div class="create-body">
            <div class="row">
                <div class="col col-md-6">
                    <div class="col col-md-10">
                        <h3>Store Address</h3>
                        <div class="gray-text"><p>This is your physical store address. This information will be used to send to drivers and also act the core location so we can work out who to send you delivery requests to.</p></div>
                        <div class="error-summary"></div>
                    </div>
                </div>
                <div class="col col-md-6">
                    <?= \frontend\widgets\Address\AddressWidget::widget(['model' => $model, 'form' => $form]); ?>
                </div>
            </div>
        </div>
                                 
                    
                    <hr style="width:90%;margin:30px;">

                    
        <div class="create-body">
            <div class="row" style="margin-top:30px;">
                <div class="col col-md-6 col-lg-6">
                    <div class="col col-md-10">
                        <h3>Contact Details</h3>
                        <div class="gray-text"><p>Please enter the details of the key contact at your store. These details will appear on your store profile will be sent to your drivers and Yello support.</p></div>
                        <div class="help-block help-block-error error-message payment-errors"></div>
                    </div>
                </div>
                <div class="col col-md-6 col-lg-6">
                                <?php echo $form->field($model, 'contact_name'); ?>
                                <?php echo $form->field($model, 'contact_phone'); ?>
                                <?php echo $form->field($model, 'contact_email'); ?>
                                <?php echo $form->field($model, 'website'); ?>

                </div>
            </div>
        </div>

                    
                    <hr style="width:90%;margin:30px;">

                    
        <div class="create-body">
            <div class="row" style="margin-top:30px;">
                <div class="col col-md-6 col-lg-6">
                    <div class="col col-md-10">
                        <h3>Store Profile</h3>
                        <div class="gray-text"><p>Now its time to tell us about your store. Add in times you are open and also tell us a bit about your business and its culture. What food it sells, how many staff you have, you know what’s your stores personality
                            </p></div>
                        <div class="help-block help-block-error error-message payment-errors"></div>
                    </div>
                </div>
                <div class="col col-md-6 col-lg-6">
                                <?php echo $form->field($model, 'businessHours')->textarea(['rows' => 4]); ?>
                </div>
                <div class="col col-md-12" style="padding-left: 30px">
                    <?php echo $form->field($model, 'storeProfile')->textarea(['rows' => 4]); ?>
                </div>
            </div>
        </div>

        <hr style="width:90%;margin:30px;">

        <div class="create-body">
            <div class="row" style="margin-top:30px;">
                <div class="col col-md-6 col-lg-6">
                    <div class="col col-md-10">
                        <h3>Store Logo</h3>
                        <div class="gray-text"><p>Your store logo will be seen in the driver app and represent your brand. Its important is of high quality and represent your brand. Upload your logo and make sure it looks impressive<br>Size 250 x 250 .jpg .png .gif</p></div>
                        <div class="help-block help-block-error error-message payment-errors"></div>
                    </div>
                </div>
                <div class="col col-md-6 col-lg-6">
                    <div class="user-photo-container big">
                        <img class="j_image-file-destination" src="/img/store_image.svg"/>
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
        </div>


                    

        <div class="create-footer text-right" style="margin-top:30px;">
            <?= Html::submitButton(\Yii::t('app', 'Finish'), ['class' => 'btn blue uppercase disableme','data-disabledmsg'=>'Saving...','data-enabledmsg'=>'Finish']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>      


</center>