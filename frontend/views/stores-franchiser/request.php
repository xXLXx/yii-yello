<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 26.06.2015
 * Time: 9:17
 */
?>

<div class="popup width-340">
    <div class="popup-title">
        <h3>Request Store to join Yello</h3>
    </div>
    <div class="popup-body">
        <div class="popup-body-inner request-review">
            <div class="clearfix j_radio_container">
                <div class="radio-input inline-block"><input id="rating-1" name="rating" value="" type="radio" checked="checked"><label class="j_radio active" for="rating-1" onclick="$('.j_single').show(); $('.j_multiple').hide(); $.colorbox.resize();">Single Store</label></div>
                <div class="radio-input inline-block"><input id="rating-2" name="rating" value="" type="radio"><label class="j_radio" for="rating-2" onclick="$('.j_single').hide(); $('.j_multiple').show(); $.colorbox.resize();">Multiple Stores</label></div>
            </div>
            <div class="j_single">
                <label for="companyName" class="bold-text">Company/Owner Name</label>
                <input id="companyName" type="text" class="text-input small j_placeholder width-100" alt="Placeholder" />
                <label for="companyEmail" class="bold-text">Email</label>
                <input id="companyEmail" type="text" class="text-input small j_placeholder width-100" alt="Placeholder" />
            </div>
            <div class="j_multiple" style="display:none;">
                <p>Upload *.csv or *.txt file<br/>Example you can download <a class="blue-text" href="#">here</a></p>
                <input id="file" type="file" size="1" />
                <br/><br/>
            </div>
            <div>
                <a href="franchisors-settings-invitations.html" class="btn">Cancel</a>
                <a href="franchisors-settings-invitations.html" class="btn blue">Request</a>
            </div>
        </div>
    </div>
</div>