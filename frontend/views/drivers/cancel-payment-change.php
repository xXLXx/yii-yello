<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\widgets\StoreInviteDriverSearch\StoreInviteDriverSearchWidget;

?>
<div class="popup width-396 store-invite">
    <?php
        $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'id' => 'driver-cancel-payment-form',
            'fieldConfig' => [
                'template' => '{input}{error}',
                'horizontalCssClasses' => [
                    'error' => 'error-message'
                ]
            ]
        ]);
    ?>
        <div class="popup-title">
            <h3><?= \Yii::t('app', 'Change payment method') ?></h3>
        </div>
        <div class="popup-body">
            <div class="popup-body-inner request-review">
                <div class="driver-info clearfix">
                    <div class="user-photo-container f-left">
                        <img src="/images/profile-thumb/<?= $driver->id; ?>"
                             alt="<?= $driver->username ?>" title="<?= $driver->username ?>" />
                    </div>
                    <div class="user-photo-info">
                        <div class="user-photo-info-inner">
                            <h3><?= $driver->username ?></h3>
                            <div class="middle-gray-text text-small-11"><?= \Yii::t('app', 'Yello ID') ?>: #<?= $driver->id ?></div>
                        </div>
                    </div>
                </div>
                <?= Html::hiddenInput("driverId", $driver->id); ?>

                Are you sure you want to cancel the change payment request?

                <div class="button-container">
                     <a href="javascript:;" class="btn j_colorbox_close"><?= \Yii::t('app', 'Cancel'); ?></a>
                    <?= Html::submitButton(\Yii::t('app', 'Confirm'), [
                        'class'   => 'btn blue j_cancel_payment_change'
                    ]) ?>
                </div>
            </div>
        </div>
    <?php
        ActiveForm::end();
    ?>
</div>