<?php
use yii\helpers\Html;
?>
<div class="driver-info">
    <div class="user-photo-container f-left">
        <a href="/drivers/profile?id=<?=$driver->id?>"><img
                src="/images/profile-thumb/<?= $driver->id; ?>"
                alt="<?= $driver->username; ?>"/>
        </a>
    </div>
    <div class="user-panel-button">

        <span class="font-star-two j_favourite-star
        <?php if (!$driver->favouriteForCurrentStore()): ?>
            hidden
        <?php endif; ?>
            "></span>

    </div>
    <div class="user-photo-info">
        <div class="user-photo-info-inner">
            <div class="name"><a href="/drivers/profile?id=<?=$driver->id?>"><?= $driver->username ?></a></div>
            <div>
                <div>
                    <?php echo \frontend\widgets\StarRating\StarRating::widget(['value' => $driver->ratings]); ?>

                </div>
                <span class="gray-text">ID #<?= $driver->id ?></span>
            </div>
        </div>
    </div>
</div>