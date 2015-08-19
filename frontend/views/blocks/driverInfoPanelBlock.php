<div class="info-panel f-right">
    <span class="info-link" title="Info"></span>
    <div class="info-popup">
        <div class="info-item font-user"><a href="/drivers/profile?id=<?=$driver->id?>" class="driver-ddl">View Profile</a></div>
        <div class="info-item font-letter-mail">Email</div>
        <div class="info-item font-edit-write">Add Note</div>
        <div class="info-item font-star-two">Add to Favourites</div>
    </div>
</div>
<div class="user-photo-container f-left">
  
    <img src="<?= $driver->imageId  ? $driver->image->thumbUrl   : '/img/Driver_Pic_bgrey_black.png' ?>"
        alt="<?= $driver->username ?>" title="<?= $driver->username ?>" />
</div>