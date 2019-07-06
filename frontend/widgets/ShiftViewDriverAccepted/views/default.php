<?php

use yii\helpers\Url;
use frontend\widgets\ShiftViewDriverAccepted\assets\ShiftViewDriverAcceptedAsset;

ShiftViewDriverAcceptedAsset::register($this);
$now =  new DateTime("now");
$startpast = $now>$shift->start;
$endpast = $now>$shift->end;

?>
<br/>
<div class="driver-info clearfix">
    <?= $this->render('//blocks//driverInfoPanelBlock', ['driver' => $driver]); ?>
    <div class="user-photo-info">
        <div class="user-photo-info-inner">
            <?= $this->render('//blocks//userPhotoInfoBlock', ['driver' => $driver]); ?>
            
                <?php if($shift->actualStart.''==''){?>
            <a href="javascript:driverunassign('<?= Url::to([
                'shift-store-owner/driver-unassign', 'driverId' => $driver->id, 'shiftId' => $shift->id
            ]); ?>');" class="red-text link-icon js-driver-unassign">
                <span class="round-btn red font-x"></span>
                <?= \Yii::t('app', 'Unassign'); ?>
            </a>
                <?php } ?>
        
        
        </div>
    </div>
</div>
