
<?php if($drivers){?>

<?php foreach ($drivers as $driver): ?>
    <?= 
        $this->render('autocomplete/item', [
            'driver' => $driver
        ]); 
    ?>
<?php endforeach; ?>

<?php }else{ ?>

<div class="search-select-item js-search-select-item">
    <div class="user-photo-container f-left">
            You have no drivers.
    </div>
</div>

<?php } ?>
