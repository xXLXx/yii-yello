<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Driver Signup / Yello';

$this->registerJsFile('/js/ImageUploadPreview.js');
$this->registerJs('ImageUploadPreview.init({hideDestination: true});');
?>
<style>
    
    #driversignupstep1-phonetype div.radio {margin-right:10px;}
    </style>


<h2 class="center">Welcome!</h2>
<div class="gray-text center">To get started on Yello you must first provide some information so we can set up your driver account.

</div>

<center>
                <div style="max-width:700px;border:1px solid #bcc0c1; border-radius:6px;position:relative;margin-top:30px;text-align: left;">

                    <div class="create-header" style="background:#f6f6f6;">
                        <div class="step-list">
                            <div class="step-item active"><span>1</span>Set up your profile</div>
                            <div class="step-item"><span>2</span>Vehicle Information</div>
                            <div class="step-item"><span>3</span>Work Information</div>
                        </div>
                    </div>
                    <?php
                        $form = ActiveForm::begin([
                            'fieldConfig' => [
                                'wrapperOptions' => [
                                    'class' => 'form-group',
                                ],
                            ],
                            'options' => ['enctype' => 'multipart/form-data']
                        ]);
                     ?>
                     <?= Html::activeHiddenInput($model, 'id'); ?>           
                    
                    
                    

                    <div class="create-body">
                        <div class="row" style="margin-top:30px;">
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                <h3>Address & phone</h3>
                                <div class="gray-text"><p>Start entering your home address in the top field and let Google help you find your address.</p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                
                                <?= \frontend\widgets\Address\AddressWidget::widget(['model' => $model, 'form' => $form]); ?>
                                <?php echo $form->field($model, 'phone'); ?>
                                <label class="control-label" for="phonetype">Phone Type</label><br>
                                <?php echo $form->field($model, 'phonetype')->radioList(['iPhone' => 'iPhone', 'Android' => 'Android'],['class' => 'form-inline form-group'])->label(false); ?>

                            </div>
                        </div>
                    </div>

                    
                    <hr style="width:90%;margin:30px;">
                    
                    
                    <div class="create-body">
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                <h3>Emergency</h3>
                                <div class="gray-text"><p>Please provide a name and phone number of someone we should contact in case of an emergency.</p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <?php echo $form->field($model, 'emergencyContactName'); ?>
                                <?php echo $form->field($model, 'emergencyContactPhone'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <hr style="width:90%;margin:30px;">
                    
                    
                    <div class="create-body">
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                <h3>Personal Profile</h3>
                                <div class="gray-text"><p>Please upload a profile pic that is recognisable as this will appear on your public profile and appear on store maps when you are completing deliveries. Good photos increase your chances of getting work.</p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">


                                <div class="input-block">
                                    <div class="company-logo">
                                        <div class="company-logo-container no-photo f-left">
                                            <img class="j_image-file-destination" src="" />
                                        </div>
                                        <div class="company-info">
                                            <h5>Profile pic</h5>
                                            <div class="gray-text">Recommended use square image with minimal dimensions 276x276px.<br>*.png, *.jpeg, *.gif</div>
                                            <div class="upload-file">
                                                <div class="link-icon font-picture-streamline blue-text">Upload Photo</div>

                                                <?/*=
                                                Html::activeFileInput($model, 'imageFile', [
                                                    'class' => 'j_image-file-input',
                                                    'id'    => 'image'
                                                ]);*/
                                                ?>
                                                <?= $form->field($model, 'imageFile')->fileInput([
                                                    'class' => 'j_image-file-input'
                                                ]) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="width:90%;margin:30px;">


                    <div class="create-body">
                        <div class="row">
                            <div class="col col-md-12">
                                <div class="col col-md-10">
                                    <h3>Personal Profile</h3>
                                    <div class="gray-text"><p>Tell us a little bit about yourself and why you like being a delivery driver</p></div>
                                    <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-12">
                                <div class="col col-md-12">
                                    <?php echo $form->field($model, 'personalProfile')->textarea(); ?>
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