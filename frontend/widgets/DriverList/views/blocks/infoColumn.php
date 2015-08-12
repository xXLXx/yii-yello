<?php $current_page = isset($_GET['category']) ? $_GET['category'] : "all"; ?>
<div class="info-panel f-right">
    <span class="info-link" title="Info"></span>
    <div class="info-popup width-175">
        <a href="driver-profile-store-owner.html" class="info-item font-user">View Profile</a>
        <div class="info-item font-letter-mail">Email</div>
        <a href="driver-profile-store-owner-add-note.html" class="info-item font-edit-write">Add Note</a>
        <div class="info-item font-star-two j_add-favourite-driver
        <?php if ($driver->favouriteForCurrentStoreOwner() || $current_page == "my"): ?>
            hidden
        <?php endif; ?>">
            Add to Favourites
        </div>
        <div class="info-item font-star-two j_remove-favourite-driver
        <?php if (!$driver->favouriteForCurrentStoreOwner() || $current_page == "my"): ?>
            hidden
        <?php endif; ?>">
            Remove from Favourites
        </div>
        <?php //if() ?>
        <div class="info-item font-dollar <?php if($current_page != 'my'){ ?>hidden<?php } ?>">Change payment method</div>
    </div>
</div>