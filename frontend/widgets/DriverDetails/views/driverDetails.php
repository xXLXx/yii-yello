<?php
/**
 * @var $this yii\web\View
 * @var $driver \common\models\Driver
 */
?>
<div class="border-top-item">
    <div class="user-shifts">
        <div class="user-photo-container">
            <img src="<?= $driver->image ? $driver->image->thumblUrl : '/img/temp/01.jpg' ?>"
                 alt="<?= $driver->username ?>" title="<?= $driver->username ?>" />
        </div>
        <div class="user-photo-info">
            <div class="user-photo-info-inner">
                <h2 class="inline-block"><?= $driver->username; ?></h2>
                <div class="info-panel inline-block">
                    <span class="info-link" title="Info"></span>
                    <div class="info-popup">
                        <a href="driver-profile-store-owner.html" class="info-item font-user">View Profile</a>
                        <div class="info-item font-letter-mail">Email</div>
                        <div class="info-item font-edit-write">Add Note</div>
                        <div class="info-item font-star-two">Add to Favourites</div>
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
