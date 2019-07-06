<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\widgets\StoreInviteDriverSearch\StoreInviteDriverSearchWidget;

?>
<div class="popup width-396 store-invite">
    <?php
        $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'id' => 'driver-payment-form',
            'fieldConfig' => [
                'template' => '{input}{error}',
                'horizontalCssClasses' => [
                    'error' => 'error-message'
                ]
            ]
        ]);
    ?>
        <?php //echo Html::activeHiddenInput($storeInviteDriverForm, 'id'); ?>
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
                <?= Html::activeHiddenInput($storeInviteDriverForm, 'driverId'); ?>
                <?php if ($driverHasStore->paymentMethod == 'yello'): ?>
                    <?= Html::hiddenInput("storeInviteDriverForm[storeRequestedMethod]", "direct"); ?>
                    <p>By requesting to pay direct you understand that Yello won't be paying the driver for their shifts and you are hereby agreeing to pay the driver directly on terms agreed to by the driver.</p>
                <?php endif; ?>

                <?php if ($driverHasStore->paymentMethod == 'direct'): ?>
                    <?= Html::hiddenInput("storeInviteDriverForm[storeRequestedMethod]", "yello"); ?>
                    <p>By requesting the driver is paid through Yello you understand that you will be charged for the drivers fees as per the Yello’s agreed terms and your account debited accordingly.</p>
                <?php endif; ?>
                <!--<div class="inline-input-block">
                    <div class="j_radio_container">
                        <div class="radio-input">
                            <input id="paymentMethod-1" name="storeInviteDriverForm[storeRequestedMethod]" value="yello"
                                   type="radio" <?php /*if ($driverHasStore->paymentMethod == 'yello'): */?>checked="checked"<?php /*endif; */?> >
                            <label class="j_radio <?php /*if ($driverHasStore->paymentMethod == 'yello'): */?>active<?php /*endif; */?>" for="paymentMethod-1"><?/*= \Yii::t('app', 'Yello Payments'); */?></label>
                        </div>
                        <div class="radio-input">
                            <input id="paymentMethod-2" name="storeInviteDriverForm[storeRequestedMethod]"  value="direct"
                                   type="radio" <?php /*if ($driverHasStore->paymentMethod == 'direct'): */?>checked="checked"<?php /*endif; */?> >
                            <label class="j_radio <?php /*if ($driverHasStore->paymentMethod == 'direct'): */?>active<?php /*endif; */?>" for="paymentMethod-2"><?/*= \Yii::t('app', 'Direct Payments'); */?></label>
                        </div>
                    </div>
                </div>
                <p>By selecting to pay direct you understand that Yello won't be paying the driver for their shifts and you are hereby agreeing to pay the driver directly on terms agreed by the driver.</p>-->
                <div class="button-container">
                     <a href="javascript:;" class="btn j_colorbox_close"><?= \Yii::t('app', 'Cancel'); ?></a>
                    <?= Html::submitButton(\Yii::t('app', 'Confirm'), [
                        'class'   => 'btn blue j_payment_method'
                    ]) ?>
                </div>
            </div>
        </div>
    <?php
        ActiveForm::end();
    ?>
</div>