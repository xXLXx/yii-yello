<?php if($driver): ?>
    <div class="assigned-shifts-filter">
        <div class="driver-info clearfix">
            <div class="user-photo-container f-left"><img src="img/temp/01.jpg" alt="John" /></div>
            <div class="user-photo-info">
                <div class="user-photo-info-inner">
                    <h3>John Smith</h3>
                    <div class="middle-gray-text text-small-11">Yello ID: #3311122</div>
                    <div>
                                <span class="star-block">
                                    <span class="font-star-two"></span>
                                    <span class="font-star-two"></span>
                                    <span class="font-star-two"></span>
                                    <span class="font-star-half"></span>
                                    <span class="font-star"></span>
                                </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <table class="strip-table">
        <col width="45%" />
        <tr class="tr-gray">
            <td class="gray-text">Availability</td>
            <td>Shift, Roamer</td>
        </tr>
        <tr>
            <td class="gray-text">Vehicle</td>
            <td>Car (Audi Q7)</td>
        </tr>
        <tr class="tr-gray">
            <td class="gray-text">Driver License</td>
            <td>
                <span class="link-icon"><span class="round-btn red font-x"></span>Not submited</span>
            </td>
        </tr>
        <tr>
            <td class="gray-text">Work in AU</td>
            <td><span class="link-icon"><span class="round-btn green font-check"></span>Legally allowed</span></td>
        </tr>
        <tr class="tr-gray j_add_note_link" style="display:none;">
            <td class="gray-text">Payment method</td>
            <td>Direct <a href="driver-profile-store-owner-change-payment-method.html" class="j_colorbox">Change</a> <span class="grey">/ or</span> <span class="orange-text">Change pending...</span></td>
        </tr>
    </table>
<?php else: ?>
    Not Found
<?php endif; ?>