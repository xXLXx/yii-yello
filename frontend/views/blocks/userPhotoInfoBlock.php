<div class="name"><?= $driver->username ?></div>
<div class="middle-gray-text">ID #<?= $driver->id ?></div>
<div>
    <?php echo \kartik\rating\StarRating::widget(['value' => $driver->ratings, 'id' => 'selected-driver' . $driver->id]); ?>
</div>