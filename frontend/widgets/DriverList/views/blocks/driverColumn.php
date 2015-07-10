<?php
use yii\helpers\Html;
?>
<div class="driver-info">
    <div class="user-photo-container f-left">
        <a href="/drivers/profile?id=<?=$driver->id?>"><img
                src="<?= $driver->image ? $driver->image->thumbUrl : '/img/temp/02.jpg' ?>"
                alt="<?= $driver->image ? $driver->image->alt : '' ?>"/>
        </a>
    </div>
    <div class="user-panel-button">

        <span class="font-star-two j_favourite-star
        <?php if (!$driver->favouriteForCurrentStoreOwner()): ?>
            hidden
        <?php endif; ?>
            "></span>

    </div>
    <div class="user-photo-info">
        <div class="user-photo-info-inner">
            <div class="name"><a href="/drivers/profile?id=<?=$driver->id?>"><?= $driver->username ?></a></div>
            <div class="state green">Available</div>
            <div>
                <span class="star-block">
                    <span class="font-star-two"></span>
                    <span class="font-star-two"></span>
                    <span class="font-star-two"></span>
                    <span class="font-star-half"></span>
                    <span class="font-star"></span>
                </span>
                <span class="gray-text">ID #<?= $driver->id ?></span>
            </div>
        </div>
    </div>
</div>