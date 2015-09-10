<?php
use kartik\rating\StarRating;
/**
 * @var $this yii\web\View
 * @var $driver \common\models\Driver
 */
if(!isset($current_page)){
    $current_page='unknown';
}
?>
<div class="border-top-item">
    <div class="user-shifts">
        <div class="user-photo-container">
            <img src="/images/profile-thumb/<?= $driver->id; ?>"
                 alt="<?= $driver->username ?>" title="<?= $driver->username ?>" />
        </div>
        <div class="user-photo-info">
            <div class="user-photo-info-inner">
                <h2 class="inline-block"><?= $driver->username; ?></h2>
                <div class="info-panel inline-block">
                    <span class="info-link" title="Info"></span>
                    <div class="info-popup">
                        <a href="/drivers/profile?id=<?=$driver->id?>" class="info-item font-user">View Profile</a>
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
                <div class="gray-text">Yello ID: #<?= $driver->id; ?></div>
                <?php echo \frontend\widgets\StarRating\StarRating::widget(['value' => $driver->ratings]); ?>
            </div>
        </div>
    </div>
</div>
