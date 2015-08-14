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
                                <h3>Address</h3>
                                <div class="gray-text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut tellus est. Donec ut eros magna.</p></div>
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
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="col col-md-10">
                                <h3>Emergency Contact Person</h3>
                                <div class="gray-text"><p>Please add an emergency contact person.</p></div>
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
                                <div class="gray-text"><p>Please tell us about yourself as a driver.</p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <?php echo $form->field($model, 'personalProfile')->textarea(); ?>

                                <div class="input-block">
                                    <div class="company-logo">
                                        <div class="company-logo-container no-photo f-left"></div>
                                        <div class="company-info">
                                            <h5>Photo</h5>
                                            <div class="gray-text">Recommended use square image with minimal dimensions 276x276px.<br>*.png, *.jpeg, *.gif</div>
                                            <div class="upload-file">
                                                <div class="link-icon font-picture-streamline blue-text">Upload Photo</div>

                                                <?/*=
                                                Html::activeFileInput($model, 'imageFile', [
                                                    'class' => 'j_image-file-input',
                                                    'id'    => 'image'
                                                ]);*/
                                                ?>
                                                <?= $form->field($model, 'imageFile')->fileInput() ?>
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