<div class="search-select-item js-search-select-item" data-driver-id="<?= $driver->id ?>">
    <div class="user-photo-container f-left">
        <img src="<?php echo $driver->image ? $driver->image->thumbUrl : '/img/Driver_Pic_bgrey_black.png' ?>"
            alt="<?= $driver->username ?>" />
    </div>
    <div class="user-photo-info">
        <div><?= $driver->username ?>, <span class="middle-gray-text">ID <?= $driver->id ?></span></div>
        <div>
            <?= $this->render('//blocks//userRatingBlock') ?>

        </div>
    </div>
</div>