<?php

use yii\helpers\Url;

?>

<div class="driver-info border-bottom clearfix">
    <?= $this->render('//blocks//driverInfoPanelBlock', ['driver' => $driver]); ?>
    <div class="user-panel-button">
        <span class="font-star-two
        <?php if (!$driver->favouriteForCurrentStore()): ?>
            hidden
        <?php endif; ?>
            "></span>
    </div>

    <div class="user-photo-info">
        <div class="user-photo-info-inner">
            <?= $this->render('//blocks//userPhotoInfoBlock', ['driver' => $driver]); ?>
            <div class="border-side-list">
                <span><a class="red-text js-applicant-control" href="javascript:declineapp('<?= Url::to([
                           'shift-store-owner/applicant-decline', 
                           'driverId' => $driver->id, 
                           'shiftId' => $shift->id
                        ]); ?>');"><?= \Yii::t('app', 'Decline') ?></a></span>
                <span> 
                    <a class="green-text js-applicant-control" 
                        href="javascript:acceptapp('<?= Url::to([
                           'shift-store-owner/applicant-accept', 
                           'driverId' => $driver->id, 
                           'shiftId' => $shift->id
                        ]); ?>');"><?= \Yii::t('app', 'Accept') ?></a></span>
            </div>
        </div>
    </div>
</div>