<?php

use frontend\widgets\StoreInviteDriverSelected\assets\StoreInviteDriverSelectedAsset;

StoreInviteDriverSelectedAsset::register($this);

?>
<div class="driver-info clearfix">
    <div class="user-photo-container f-left">
        <img src="/images/profile-thumb/<?= $driver->id; ?>"
             alt="<?= $driver->username ?>" title="<?= $driver->username ?>" />
    </div>
    <div class="user-photo-info">
        <div class="user-photo-info-inner">
            <h3><?= $driver->username ?></h3>
            <div class="middle-gray-text text-small-11"><?= \Yii::t('app', 'Yello ID') ?>: #<?= $driver->id ?></div>
            <div>
                <?= \kartik\rating\StarRating::widget(['value' => $driver->ratings]); ?>
            </div>
        </div>
    </div>
</div>
<br>
<table class="js-driver-info-table-replace strip-table">
    <col width="45%" />
    <tr>
        <td class="gray-text">Vehicle</td>
        <td><?php if ($driver->vehicle):?>
                <?= $driver->vehicle->vehicleType->title ?>
                (<?= $driver->vehicle->model ?>, <?= $driver->vehicle->year ?>)
            <?php else: ?>
                Not Found
            <?php endif; ?>
        </td>
    </tr>
    <tr class="tr-gray">
        <td class="gray-text">Driver License</td>
        <td>
            <?php if($driver->userDriver && $driver->userDriver->driverLicenseNumber): ?>
                <span class="link-icon"><span class="round-btn green font-check"></span>Submited</span>
            <?php else: ?>
                <span class="link-icon"><span class="round-btn red font-x"></span>Not submited</span>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="gray-text">Work in AU</td>
        <td><?php if ($driver->userDriver && $driver->userDriver->isAllowedToWorkInAustralia): ?>
                <span class="link-icon"><span class="round-btn green font-check"></span>Legally allowed</span>
            <?php else: ?>
                <span class="link-icon"><span class="round-btn red font-x"></span>Not allowed</span>
            <?php endif; ?></td>
    </tr>
    <tr class="tr-gray j_add_note_link" style="display:none;">
        <td class="gray-text"><?= \Yii::t('app', 'Payment method') ?></td>
        <td>Direct <a href="driver-profile-store-owner-change-payment-method.html" class="j_colorbox"><?= \Yii::t('app', 'Change') ?></a>
            <span class="grey">/ or</span> <span class="orange-text"><?= \Yii::t('app', 'Change pending') ?>...</span></td>
    </tr>
</table>
<?php $this->registerJs('StoreInviteDriverSelectedWidget.init();'); ?>