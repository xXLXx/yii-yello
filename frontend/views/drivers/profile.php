 <div class="two-column">
        <div class="col-left f-left">
            <h2><a class="gray-text" href="drivers.html">Drivers /</a> Driver profile</h2>
            <div class="info-panel blue f-right">
                <span class="info-link" title="Info"></span>
                <div class="info-popup">
                    <div class="info-item font-letter-mail">Email</div>
                    <div class="info-item font-edit-write">Add Note</div>
                    <div class="info-item font-delete-garbage-streamline">Archive</div>
                </div>
            </div>
            <div class="driver-info profile-view clearfix">
                <div class="user-photo-container f-left">
                    <a href="driver-profile-store-owner.html">
                        <img
                            src="<?= $driver->image ? $driver->image->thumbUrl : '/img/temp/02.jpg' ?>"
                            alt="<?= $driver->image ? $driver->image->alt : '' ?>"/>
                    </a>
                </div>
                <div class="user-photo-info">
                    <div class="user-photo-info-inner">
                        <h2><?= $driver->username ?></h2>
                        <div class="text-small-11 gray-text">Yello ID: #<?= $driver->id ?></div>
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
                        <h4>Achievements</h4>
                        <div class="achivements-list big-size">
                            <div class="item check"></div>
                        </div>
            <h4>Public details</h4>
            <table class="strip-table">
                <col width="30%" />
                <tr class="tr-gray">
                    <td class="gray-text">Availability</td>
                    <td><?= $driver->userDriver->availability ?></td>
                </tr>
                <tr>
                    <td class="gray-text">Vehicle</td>
                    <td>
                        <?php if ($driver->vehicle):?>
                            <?= $driver->vehicle->vehicleType->title ?>
                            (<?= $driver->vehicle->model ?>, <?= $driver->vehicle->year ?>)
                            <a href="#">View</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="tr-gray">
                    <td class="gray-text">Driver License</td>
                    <td>
                        <?php if($driver->userDriver->driverLicenseNumber): ?>
                            <span class="link-icon"><span class="round-btn green font-check"></span>Submited</span>
                            <a href="#">View</a>
                        <?php else: ?>
                            <span class="link-icon"><span class="round-btn red font-x"></span>Not submited</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="gray-text">Work in AU</td>
                    <td>
                        <?php if ($driver->userDriver->driverLicenseNumber): ?>
                            <span class="link-icon"><span class="round-btn green font-check"></span>Legally allowed to work in Australia</span>
                        <?php else: ?>
                            <span class="link-icon"><span class="round-btn red font-x"></span></span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <h4>Private details</h4>
            <table class="strip-table">
                <col width="30%" />
                <tr class="tr-gray">
                    <td class="gray-text">Email</td>
                    <td><?= $driver->email?></td>
                </tr>
                <tr>
                    <td class="gray-text">Address</td>
                    <td><?= $driver->userDriver->address1 ?></td>
                </tr>
                <tr class="tr-gray">
                    <td class="gray-text">Phone</td>
                    <td> </td>
                </tr>
                <tr>
                    <td class="gray-text">Emergency contact<br/>Person</td>
                    <td>
                        <?= $driver->userDriver->emergencyContactName ? $driver->userDriver->emergencyContactName : '' ?><br/>
                        <?= $driver->userDriver->emergencyContactPhone ? $driver->userDriver->emergencyContactPhone : '' ?>
                    </td>
                </tr>
                <tr class="tr-gray">
                    <td class="gray-text">T-Shirt Size</td>
                    <td></td>
                </tr>
            </table>
            <h4>Locations</h4>
            <div class="location-list">
                <?php foreach ($driver->suburbs as $suburb): ?>
                    <div class="location-item"><?= $suburb->title ?></div>
                <?php endforeach; ?>
            </div>
            <h4>Profile</h4>
            <div><?= $driver->userDriver->personalProfile ?></div>
            </div>
        <div class="col-right f-right">
            <div class="border-top-list profile-view">
                <div class="border-top-item">
                    <div class="table-block">
                        <div class="table-cell-item">
                            <h4>Completed shifts</h4>
                            <h2 class="h1"><?= $completedShiftCount ?></h2>
                        </div>
                        <div class="table-cell-item">
                            <h4>Drivers</h4>
                            <h2 class="h1"><?= $driversCount ?></h2>
                        </div>
                    </div>
                </div>
                <div class="border-top-item">
                    <div class="j_add_note_link" style="display:none;">
                        <div class="note-block">
                            <div class="note-item">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas imperdiet ultrices leo. Duis in orci porta, imperdiet diam at, euismod sapien.</div>
                            <div class="note-button">
                                <span><a href="#" class="brown-text link-icon font-pencil">Edit Note</a></span>
                                <span><a href="#" class="brown-text link-icon font-delete-garbage-streamline">Delete</a></span>
                            </div>

                        </div>
                    </div>
                    <?php if ($reviews):?>
                        <h3 class="middle-gray-text">Reviews</h3>
                        <div class="company-list">
                            <?php foreach ($reviews as $review):?>
                                <div class="company-item">
                                    <h5><?= $review->title ?></h5>
                                        <span class="star-block big">
                                            <span class="font-star-two"></span>
                                            <span class="font-star-two"></span>
                                            <span class="font-star-two"></span>
                                            <span class="font-star-half"></span>
                                            <span class="font-star"></span>
                                        </span>
                                    <div><?= $review->text?></div>
                                    <div class="gray-text">
                                        <?php
                                            $dateTime = new \DateTime();
                                            $dateTime->setTimestamp($review->createdAt)
                                        ?>
                                        <?= Yii::$app->formatter->asDatetime($dateTime)?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
