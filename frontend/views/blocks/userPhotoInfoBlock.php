<div class="name"><?= $driver->username ?></div>
<div class="middle-gray-text">ID #<?= $driver->id ?></div>
<div>
    <?php echo \frontend\widgets\StarRating\StarRating::widget(['value' => $driver->ratings]); ?>
</div>