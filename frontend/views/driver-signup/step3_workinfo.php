<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Driver Signup / Yello';
?>



<h2 class="center">Some serious stuff</h2>
<center>
<div class="gray-text center" style="max-width:700px;">Final step. We just need to set up your payment and business information so you can work on Yello
<br/><br>
    Yello can be used by businesses who employ their drivers directly or by businesses who want to book drivers via the platform as independent contractors. As a driver, if you have a business ABN you can work for any store on Yello as an independent contractor. If you don’t have an ABN you can only work for those stores who employ you directly and connect with you via Yello.
</div>


                <div style="max-width:700px;border:1px solid #bcc0c1; border-radius:6px;position:relative;margin-top:30px;text-align: left;">

                    <div class="create-header" style="background:#f6f6f6;">
                        <div class="step-list">
                            <div class="step-item complete"><span>1</span>Set up your profile</div>
                            <div class="step-item complete"><span>2</span>Vehicle Information</div>
                            <div class="step-item active"><span>3</span>Work Information</div>
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
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                <h3>Business Details</h3>
                                <div class="gray-text"><p>To work on Yello as an independent contractor in Australia you are required to have an ABN number.<br>
                                        If you have already set yourself up as business or sole trader please provide your business name and ABN number and let us know if you are registered for GST.
                                    </p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <?php echo $form->field($model, 'registeredForGST')  ->checkbox(); ?>
                               <?php echo $form->field($model, 'companyName') ?>
                               <?php echo $form->field($model, 'ABN') ?>
                            </div>
                        </div>
                    </div>




                    <hr style="width:90%;margin:30px;">


                    <div class="create-body">
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                <h3>Bank Account Details</h3>
                                <div class="gray-text"><p>Please enter your bank details so Yello can organise payment from the stores you work for.
                                    </p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                               <?php echo $form->field($model, 'bankName') ?>
                               <?php echo $form->field($model, 'bsb') ?>
                               <?php echo $form->field($model, 'accountNumber') ?>
                            </div>
                        </div>
                    </div>
                    <hr style="width:90%;margin:30px;">
                    <div class="create-body">
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                <h3>Eligibility</h3>
                                <div class="gray-text"><p>Please tick to confirm you are either an Australian resident or have a valid and relevant working visa that allows you to work in Australia.</p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                               <?php echo $form->field($model, 'isAvailableToWork')->checkbox() ?>
                            </div>
                        </div>
                    </div>
                    <div class="create-body">
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                    <h3>Terms and conditions</h3>
                                    <div class="gray-text"><p>Please read the terms and conditions associated to working on Yello. Once read please check the box to the right to confirm you agree to those terms.</p></div>
                                    <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <?php echo $form->field($model, 'agreedDriverTandC')->checkbox(['label' => 'I agree to the <a class="j_colorbox" href="'. \yii\helpers\Url::to(['site/terms-conditions']).'">terms and conditions</a>']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="create-footer text-right" style="margin-top:30px;">
                        <?= Html::submitButton(\Yii::t('app', 'Next Step'), ['class' => 'btn blue uppercase disableme']); ?>
                    </div>
                                                        
                    
                    <?php ActiveForm::end(); ?>                    
                </div>
</center>