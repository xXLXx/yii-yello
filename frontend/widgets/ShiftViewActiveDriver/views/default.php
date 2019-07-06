<?php
/**
 * @var $driver \common\models\Driver
 */
?>
<br/>
<div class="driver-info clearfix">
    <?= $this->render('//blocks//driverInfoPanelBlock', ['driver' => $driver]); ?>
    <div class="user-photo-info">
        <div class="user-photo-info-inner">
            <?= $this->render('//blocks//userPhotoInfoBlock', ['driver' => $driver]); ?>
        </div>
    </div>
</div>