<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Driver Signup / Yello';

$this->registerJsFile('/js/ImageUploadPreview.js');
$this->registerJs('ImageUploadPreview.init({hideDestination: true});');
$this->registerJs('ImageUploadPreview.init({
    inputSelector: "j_image-file-input-vehicle",
    destinationSelector: "j_image-file-destination-vehicle",
    hideDestination: true
});');
?>



<h2 class="center">Tell us about your ride</h2>
<div class="gray-text center">Now tell us a little bit about what you ride and drive.</div>

<center>
                <div style="max-width:700px;border:1px solid #bcc0c1; border-radius:6px;position:relative;margin-top:30px;text-align: left;">

                    <div class="create-header" style="background:#f6f6f6;">
                        <div class="step-list">
                            <div class="step-item complete"><span>1</span>Set up your profile</div>
                            <div class="step-item active"><span>2</span>Vehicle Information</div>
                            <div class="step-item"><span>3</span>Work Information</div>
                        </div>
                    </div>
                    <?php
                        $form = ActiveForm::begin([
                            'fieldConfig' => [
                                'wrapperOptions' => [
                                    'class' => 'form-group',
                                ]
                            ],
                            'options' => ['enctype' => 'multipart/form-data']
                        ]);
                     ?>
                     <?= Html::activeHiddenInput($model, 'id'); ?>           


                    
                    

                    <div class="create-body">
                        <div class="row" style="margin-top:30px;">
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                <h3>Your Vehicle</h3>
                                <div class="gray-text"><p>Do you deliver using a motor cycle or a car. Its important that its road worthy. Please provide some details about your ride and a pic of your vehicle ( if you don’t have a car pic available you can add one later in the app)
                                    </p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <?= Html::activeHiddenInput($model, 'driverId'); ?>
                                <?php echo $form->field($model, 'vehicleTypeId')->radioList(['1' => 'Car', '2' => 'Bike'],['class' => 'form-inline form-group'])->label(false); ?>
                               <?php echo $form->field($model, 'make') ?>
                                <?php echo $form->field($model, 'model') ?>
                               <?php echo $form->field($model, 'registration',['options'=>['class'=>'col col-sm-8 col-md-8 col-lg-8','style'=>'padding-left:0;padding-right:0;']]) ?>
                               <?php echo $form->field($model, 'year',['options'=>['class'=>'col col-sm-4 col-md-3 col-lg-3 pull-right','style'=>'padding-left:0;padding-right:0;']]) ?>
                                
                                <div class="input-block inline-block">
                                    <label>Photo</label>
                                    <div class="company-logo big">
                                        <div class="company-logo-container no-photo big">
                                            <img class="j_image-file-destination-vehicle" src="" />
                                        </div>
                                        <div class="company-info big">

                                            <div class="gray-text">Recommended use square image with minimal dimensions 276x276px.<br>*.png, *.jpeg, *.gif</div>
                                            <div class="upload-file">
                                                <div class="link-icon font-picture-streamline blue-text">Upload Photo</div>
                                                <?=
                                Html::activeFileInput($model, 'vehiclePhotoFile', [
//                                    'id'    => 'image'
                                    'class' => 'j_image-file-input-vehicle'
                                ]);
                                ?>
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
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                <h3>Driver's License</h3>
                                <div class="gray-text"><p>To be a Yello driver you have to have held your full license for at least 12 months (Green p’s). Please provide details and a pic of your driver’s license
                                    </p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                               <?php echo $form->field($model, 'licenseNumber') ?>


                                <div class="input-block">
                                    <label>Photo</label>
                                    <div class="company-logo big">
                                        <div class="company-logo-container no-photo big">
                                            <img class="j_image-file-destination" src="" />
                                        </div>
                                        <div class="company-info big">

                                            <?= Html::error($model, 'licensePhotoFile', ['class' => 'error-message']); ?>
                                            <div class="gray-text">Recommended use square image with minimal dimensions 276x276px.<br>*.png, *.jpeg, *.gif</div>
                                            <div class="upload-file">
                                                <div class="link-icon font-picture-streamline blue-text">Upload Photo</div>
                                <?=
                                Html::activeFileInput($model, 'licensePhotoFile', [
                                //   'id'    => 'image'
                                    'class' => 'j_image-file-input'
                                ]);
                                ?>                                                
                                        
                                            </div>
                                        </div>
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