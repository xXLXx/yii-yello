<div class="info-panel f-right">
    <span class="info-link" title="Info"></span>
    <div class="info-popup">
        <div class="info-item font-user">View Profile</div>
        <div class="info-item font-letter-mail">Email</div>
        <div class="info-item font-edit-write">Add Note</div>
        <div class="info-item font-star-two">Add to Favourites</div>
    </div>
</div>
<div class="user-photo-container f-left">
  
<!--    <img src="<?//= $driver->image ? $driver->image->thumblUrl : '/img/driver_head.svg' ?>"  -->
    <img src="<?= $driver->imageId  ? '/upload/images/'.$driver->imageId.'-thumb.jpg'   : '/img/driver_head.svg' ?>"
        alt="<?= $driver->username ?>" title="<?= $driver->username ?>" />
</div>