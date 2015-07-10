<?php

use yii\helpers\Url;
use frontend\widgets\ShiftViewDriverAccepted\assets\ShiftViewDriverAcceptedAsset;

ShiftViewDriverAcceptedAsset::register($this);
?>
<br/>
<div class="driver-info clearfix">
    <?= $this->render('//blocks//driverInfoPanelBlock', ['driver' => $driver]); ?>
    <div class="user-photo-info">
        <div class="user-photo-info-inner">
            <?= $this->render('//blocks//userPhotoInfoBlock', ['driver' => $driver]); ?>
            <a href="<?= Url::to([
                'shift-store-owner/driver-unassign', 'driverId' => $driver->id, 'shiftId' => $shift->id
            ]); ?>" class="red-text link-icon js-driver-unassign">
                <span class="round-btn red font-x"></span>
                <?= \Yii::t('app', 'Unassign'); ?>
            </a>
        </div>
    </div>
</div>

<?= $this->registerJs('ShiftViewDriverAcceptedWidget.init();'); ?>