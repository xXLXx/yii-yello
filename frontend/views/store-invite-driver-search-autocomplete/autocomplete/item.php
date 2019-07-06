<div class="search-select-item js-search-select-item" data-driver-id="<?= $driver->id ?>">
    <div class="user-photo-container f-left">
        <img src="/images/profile-thumb/<?php echo $driver->id; ?>"
            alt="<?= $driver->username ?>" />
    </div>
    <div class="user-photo-info">
        <div><?= $driver->username ?>, <span class="middle-gray-text">ID <?= $driver->id ?></span></div>
        <?php echo \kartik\rating\StarRating::widget(['value' => $driver->ratings]); ?>
        <div class="rating-overlay"></div>
    </div>
</div>