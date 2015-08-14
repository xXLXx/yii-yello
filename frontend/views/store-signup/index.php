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
                                <?php echo Html::activeHiddenInput($model, 'companyId'); ?>
                                <?php echo Html::activeHiddenInput($model, 'addressfk'); ?>
                                <?php echo $form->field($model, 'companyName'); ?>
                                <?php echo $form->field($model, 'ABN'); ?>
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
                                <?= \frontend\widgets\Address\AddressWidget::widget(['model' => $model, 'form' => $form]); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="create-footer text-right" style="margin-top:30px;">
                        <?= Html::submitButton(\Yii::t('app', 'Next Step'), ['class' => 'btn blue uppercase disableme']); ?>
                    </div>
        <?php ActiveForm::end(); ?>
                </div>      
</center>