<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\DriversAsset;

DriversAsset::register($this);

$this->registerJs('$(function(){DriverNote.init();})');
?>
<div class="popup width-340">
    <div class="popup-title">
        <h3>Add/Edit Note</h3>
    </div>
    <div class="popup-body">
        <div class="popup-body-inner request-review">

            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= Html::activeHiddenInput($model, 'driverId', ['value' => $driverId]); ?>

            <?php
            foreach($errors as $sub_error){
                foreach($sub_error as $error){
                    echo $error;
                    echo "<br/>";
                }
            }; ?>

            <?= Html::activeTextarea($model, 'note', [
                'placeholder' => Yii::t ('app', 'Enter note'),
                'class' => 'textarea',
                'rows' => 6
            ]);
            ?>

            <div class="button-container">
                <a href="javascript:;" class="btn j_colorbox_close"><?= \Yii::t('app', 'Cancel'); ?></a>
                <?= Html::submitButton(\Yii::t('app', 'Add(save)'), [
                    'class'   => 'btn blue j_add-note'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>