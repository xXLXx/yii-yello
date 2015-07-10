<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\widgets\StoreInviteDriverSearch\StoreInviteDriverSearchWidget;

?>
<div class="popup width-340 store-invite">
    <?php
        $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'id' => 'store-invite-driver-form',
            'fieldConfig' => [
                'template' => '{input}{error}',
                'horizontalCssClasses' => [
                    'error' => 'error-message'
                ]
            ],
            'options' => [
                'enctype' => 'multipart/form-data'
            ]
        ]);
    ?>
        <?= Html::activeHiddenInput($storeInviteDriverForm, 'id'); ?>
        <div class="popup-title">
            <h3><?= \Yii::t('app', 'Invite Driver') ?></h3>
        </div>
        <div class="popup-body">
            <div class="popup-body-inner request-review">
                <?= Html::errorSummary($storeInviteDriverForm) ?>
                <div class="clearfix j_radio_container">
                    <div class="radio-input inline-block">
                        <input id="rating-1" name="rating" value="" type="radio" checked="checked">
                        <label class="j_radio active" for="rating-1"><?= \Yii::t('app', 'Search on Yello') ?></label></div>
                    <div class="radio-input inline-block">
                        <input id="rating-2" name="rating" value="" type="radio">
                        <label class="j_radio" for="rating-2"><?= \Yii::t('app', 'Send invite') ?></label></div>
                </div>
                <?= 
                    StoreInviteDriverSearchWidget::widget([
                        'model' => $storeInviteDriverForm
                    ]);
                ?>
                <div class="js-driver-info-table"></div>
                <div class="button-container">
                     <a href="javascript:;" class="btn j_colorbox_close"><?= \Yii::t('app', 'Cancel'); ?></a>
                    <?= Html::submitButton(\Yii::t('app', 'Send'), [
                        'class'   => 'btn blue'
                    ]) ?>
                </div>
            </div>
        </div>
    <?php
        ActiveForm::end();
    ?>
</div>