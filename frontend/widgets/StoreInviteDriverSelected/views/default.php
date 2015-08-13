<?php

use frontend\widgets\StoreInviteDriverSelected\assets\StoreInviteDriverSelectedAsset;

StoreInviteDriverSelectedAsset::register($this);

?>
<div class="driver-info clearfix">
    <div class="user-photo-container f-left">
        <img src="<?= $driver->image ? $driver->image->thumbUrl : '/img/driver_head.svg' ?>"
             alt="<?= $driver->username ?>" title="<?= $driver->username ?>" />
    </div>
    <div class="user-photo-info">
        <div class="user-photo-info-inner">
            <h3><?= $driver->username ?></h3>
            <div class="middle-gray-text text-small-11"><?= \Yii::t('app', 'Yello ID') ?>: #<?= $driver->id ?></div>
            <div>
                <?= $this->render('//blocks//userRatingBlock') ?>
            </div>
        </div>
    </div>
</div>
<br>
<table class="js-driver-info-table-replace strip-table">
    <col width="45%" />
    <tr class="tr-gray">
        <td class="gray-text">Availability</td>
        <td>Shift, Roamer</td>
    </tr>
    <tr>
        <td class="gray-text">Vehicle</td>
        <td>Car (Audi Q7)</td>
    </tr>
    <tr class="tr-gray">
        <td class="gray-text">Driver License</td>
        <td>
            <span class="link-icon"><span class="round-btn red font-x"></span>Not submited</span>
        </td>
    </tr>
    <tr>
        <td class="gray-text">Work in AU</td>
        <td><span class="link-icon"><span class="round-btn green font-check"></span>Legally allowed</span></td>
    </tr>
    <tr class="tr-gray j_add_note_link" style="display:none;">
        <td class="gray-text"><?= \Yii::t('app', 'Payment method') ?></td>
        <td>Direct <a href="driver-profile-store-owner-change-payment-method.html" class="j_colorbox"><?= \Yii::t('app', 'Change') ?></a>
            <span class="grey">/ or</span> <span class="orange-text"><?= \Yii::t('app', 'Change pending') ?>...</span></td>
    </tr>
</table>
<?php $this->registerJs('StoreInviteDriverSelectedWidget.init();'); ?>