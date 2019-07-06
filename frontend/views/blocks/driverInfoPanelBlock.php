<div class="info-panel f-right">
    <span class="info-link" title="Info"></span>
    <div class="info-popup">
        <a class="info-item font-user driver-ddl j_colorbox" href="/drivers/profile?id=<?=$driver->id?>&quickLayout=1">View Profile</a>
        <a class="info-item font-letter-mail" href="mailto:<?= $driver->email; ?>">Email</a>
        <a href="<?= \yii\helpers\Url::to(['drivers/note']) ?>?driverId=<?= $driver->id ?>" class="info-item font-edit-write j_colorbox"><?= \Yii::t('app', 'Add Note') ?></a>
        <div class="info-item font-star-two j_add-favourite-driver
                        <?php if ($driver->favouriteForCurrentStore()): ?>
                         hidden
                        <?php endif; ?>" data-driverid="<?= $driver->id; ?>">
            Add to Favourites
        </div>
        <div class="info-item red-text font-star-two j_remove-favourite-driver
                        <?php if (!$driver->favouriteForCurrentStore()): ?>
                            hidden
                        <?php endif; ?>" data-driverid="<?= $driver->id; ?>">
            Remove from Favourites
        </div>
    </div>
</div>
<div class="user-photo-container f-left">
  
    <img src="/images/profile-thumb/<?= $driver->id; ?>"
        alt="<?= $driver->username ?>" title="<?= $driver->username ?>"  onError="this.onerror=null;this.src='/img/Driver_Pic_bgrey_black.png';"  />
</div>