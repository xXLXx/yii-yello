<?php $current_page = isset($_GET['category']) ? $_GET['category'] : "all"; ?>
<div class="info-panel f-right">
    <span class="info-link" title="Info"></span>
    <div class="info-popup width-175">
        <a href="/drivers/profile?id=<?=$driver->id?>" class="info-item font-user">View Profile</a>
        <a class="info-item font-letter-mail" href="mailto:<?= $driver->email; ?>">Email</a>
        <a href="/drivers/note?driverId=<?=$driver->id?>" class="info-item font-edit-write j_colorbox">Add Note</a>
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
        <?php //if() ?>
        <div class="info-item font-dollar <?php if($current_page != 'my'){ ?>hidden<?php } ?>">Change payment method</div>
    </div>
</div>