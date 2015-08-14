<?php
/**
 * @var $this yii\web\View
 * @var $driver \common\models\Driver
 */
?>
<div class="border-top-item">
    <div class="user-shifts">
        <div class="user-photo-container">
            <img src="<?= $driver->image ? $driver->image->thumbUrl : '/img/Driver_Pic_bgrey_black.png' ?>"
                 alt="<?= $driver->username ?>" title="<?= $driver->username ?>" />
        </div>
        <div class="user-photo-info">
            <div class="user-photo-info-inner">
                <h2 class="inline-block"><?= $driver->username; ?></h2>
                <div class="info-panel inline-block">
                    <span class="info-link" title="Info"></span>
                    <div class="info-popup">
                        <a href="/drivers/profile?id=<?=$driver->id?>" class="info-item font-user">View Profile</a>
                        <div class="info-item font-letter-mail">Email</div>
                        <div class="info-item font-edit-write">Add Note</div>
                        <div class="info-item font-star-two j_add-favourite-driver
                        <?php if ($driver->favouriteForCurrentStore() || $current_page == "my"): ?>
                            hidden
                        <?php endif; ?>">
                            Add to Favourites
                        </div>
                        <div class="info-item font-star-two j_remove-favourite-driver
                        <?php if (!$driver->favouriteForCurrentStore() || $current_page == "my"): ?>
                            hidden
                        <?php endif; ?>">
                            Remove from Favourites
                        </div>
                    </div>
                </div>
                <div class="gray-text">Yello ID: #<?= $driver->id; ?></div>
                <div class="star-block big inline-block">
                    <span class="font-star-two"></span>
                    <span class="font-star-two"></span>
                    <span class="font-star-two"></span>
                    <span class="font-star-half"></span>
                    <span class="font-star"></span>
                </div>
            </div>
        </div>
    </div>
</div>
