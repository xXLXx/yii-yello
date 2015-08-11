<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Driver Signup / Yello';
?>



<h2 class="center">Welcome!</h2>
<div class="gray-text center">To get started on Yello you must first complete the following steps:

</div>

<center>
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
                                <h3>Company Details</h3>
                                <div class="gray-text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut tellus est. Donec ut eros magna.</p></div>
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
                                <div class="gray-text"><p>lorem ipsum donor</p></div>
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
                    <div class="create-body">
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                <h3>Availability</h3>
                                <div class="gray-text"><p>lorem ipsum donor</p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                               <?php echo $form->field($model, 'isAvailableToWork')->checkbox() ?>
                               <?php echo $form->field($model, 'agreedDriverTandC')->checkbox() ?>
                            </div>
                        </div>
                    </div>
                    <div class="create-footer text-right" style="margin-top:30px;">
                        <?= Html::submitButton(\Yii::t('app', 'Next Step'), ['class' => 'btn blue uppercase disableme']); ?>
                    </div>
                                                        
                    
                    <?php ActiveForm::end(); ?>                    
                </div>
</center>