<br/>
<div class="driver-info clearfix">
    <?= $this->render('//blocks//driverInfoPanelBlock', ['driver' => $driver]); ?>
    <div class="user-photo-info">
        <div class="user-photo-info-inner">
            <?= $this->render('//blocks//userPhotoInfoBlock', ['driver' => $driver]); ?>
            <a href="javascript:DriverSearchWidget.removedriver();" class="red-text link-icon">
                <span class="round-btn red font-x"></span>
                <?= \Yii::t('app', 'Delete'); ?>
            </a>
        </div>
    </div>
</div>