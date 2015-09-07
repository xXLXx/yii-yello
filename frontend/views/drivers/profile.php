<?php
use frontend\assets\DriversAsset;

DriversAsset::register($this);
$this->registerJs('$(function(){ AddFavouriteDriver.init(); StoreInviteDriverController.init(); InviteDriver.init(); DriverNote.init()})');
$driverId = $driver->id;
?>
 <div class="two-column">
        <div class="col-left f-left">
            <h2><a class="gray-text" href="/drivers">Drivers /</a> Driver profile</h2>
            <div class="info-panel blue f-right">
                <span class="info-link" title="Info"></span>
                <div class="info-popup">
                    <a class="info-item font-letter-mail" href="mailto:<?= $driver->email; ?>">Email</a>
                    <div><a href="<?= \yii\helpers\Url::to(['drivers/note']) ?>?driverId=<?= $driver->id ?>" class="info-item font-edit-write j_colorbox"><?= \Yii::t('app', 'Add Note') ?></a></div>


                    <div class="info-item font-link j_invite-driver <?php if($invited){ ?> hidden <?php } ?>" data-driverid="<?= $driverId; ?>">Invite to store</div>

                    <div class="info-item font-star-two j_add-favourite-driver
                        <?php if ($driver->favouriteForCurrentStore()): ?>
                         hidden
                        <?php endif; ?>" data-driverid="<?= $driver->id; ?>">
                        Add to Favourites
                    </div>
                    <div class="info-item red-text font-star-two j_remove-favourite-driver
                        <?php if (!$driver->favouriteForCurrentStore()): ?>
                            hidden
                        <?php endif; ?>" data-driverid="<?= $driver->id; ?>">
                        Remove from Favourites
                    </div>
                </div>
            </div>
            <div class="driver-info profile-view clearfix">
                <div class="user-photo-container f-left">
                    <a href="driver-profile-store-owner.html">
                        <img
                            src="<?= $driver->image ? $driver->image->thumbUrl : '/img/Driver_Pic_bgrey_black.png' ?>"
                            alt="<?= $driver->image ? $driver->image->alt : '' ?>"/>
                    </a>
                </div>
                <div class="user-photo-info">
                    <div class="user-photo-info-inner">
                        <h2><?= $driver->username ?></h2>
                        <div class="text-small-11 gray-text">Yello ID: #<?= $driver->id ?></div>
                            <div>


                                <?php echo \kartik\rating\StarRating::widget(['value' => $review_avg]); ?>
                                <!--<span class="star-block">
                                    <span class="font-star-two"></span>
                                    <span class="font-star-two"></span>
                                    <span class="font-star-two"></span>
                                    <span class="font-star"></span>
                                    <span class="font-star"></span>
                                </span>-->
                                <div class="border-side-list j_invited_message <?php if(!$invited || $connected){ ?> hidden <?php } ?>"><span>Invited to your store</span><span class="red-text"><a class="red-text j_disconnect-driver" href="#" data-driverid="<?= $driverId; ?>">Cancel</a></span></div>
                                <div class="border-side-list j_confirm_message <?php if(!$connected){ ?> hidden <?php } ?>"><span class="green-text">Connected to your store</span><span><a class="red-text link-icon font-link-broken j_disconnect-driver" href="#" data-driverid="<?= $driverId; ?>">Disconnect</a></span></div>
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
                <!--<tr class="tr-gray">
                    <td class="gray-text">Availability</td>
                    <td><?/*= $driver->userDriver->availability */?></td>
                </tr>-->
                <tr>
                    <td class="gray-text">Vehicle</td>
                    <td>
                        <?php if ($driver->vehicle):?>
                            <?= $driver->vehicle->vehicleType->title ?>
                            (<?= $driver->vehicle->model ?>, <?= $driver->vehicle->year ?>, <?= $driver->vehicle->registration; ?>)
                            <?php if($connected && $driver->vehicle->image){ ?>
                            <a href="<?= $driver->vehicle->image->originalUrl ?>" class="j_colorbox_photo">View</a>
                            <?php } ?>
                        <?php else: ?>
                            Not Found
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="tr-gray">
                    <td class="gray-text">Driver License</td>
                    <td>
                        <?php if($driver->vehicle->licensePhoto): ?>
                            <span class="link-icon"><span class="round-btn green font-check"></span>Submited</span>
                            <?php if($connected){ ?><a href="<?= $driver->vehicle->licensePhoto->originalUrl ?>" class="j_colorbox_photo ajax">View</a><?php } ?>
                            <?php if(isset($_GET['rotate_image'])){ ?><a href="javascript://" class="j_photo_rotate">Rotate</a><?php } ?>
                        <?php else: ?>
                            <span class="link-icon"><span class="round-btn red font-x"></span>Not submited</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="gray-text">Work in AU</td>
                    <td>
                        <?php if ($driver->userDriver->isAllowedToWorkInAustralia): ?>
                            <span class="link-icon"><span class="round-btn green font-check"></span>Legally allowed to work in Australia</span>
                        <?php else: ?>
                            <span class="link-icon"><span class="round-btn red font-x"></span>Not allowed</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <?php if($connected){ ?>
            <h4>Private details</h4>
            <table class="strip-table">
                <col width="30%" />
                <tr class="tr-gray">
                    <td class="gray-text">Email</td>
                    <td><?= $driver->email?></td>
                </tr>
                <tr>
                    <td class="gray-text">Address</td>
                    <td><?= $driver->fulladdress; ?></td>
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
                <tr class="tr-gray">
                    <td class="gray-text">Payment Method</td>
                    <?php
                    $paymentMethod = $driverHasStore->paymentMethod;
                    $storeRequestedMethod = $driverHasStore->storeRequestedMethod;
                    ?>
                    <td><?= ucfirst($paymentMethod); ?>
                        <span class="orange-text j_payment_change_text <?php if(!$storeRequestedMethod){ ?>hidden<?php } ?>">Change pending...</span>&nbsp;
                        <a id="j_cancel_payment_change" href="<?= \yii\helpers\Url::to(['drivers/cancel-payment-change']) ?>?driverId=<?= $driver->id ?>" data-driverId="<?=$driverId; ?>" class="j_colorbox <?php if(!$storeRequestedMethod){ ?>hidden<?php } ?>">Cancel</a>
                        <a id="j_payment_change" href="<?= \yii\helpers\Url::to(['drivers/change-payment-method']) ?>?driverId=<?= $driver->id ?>"  class="j_colorbox <?php if($storeRequestedMethod){ ?>hidden<?php } ?>">Change</a>
                    </td>
                </tr>
            </table>
            <?php } ?>
            <!-- <h4>Locations</h4>
                 TODO:jovani
                  <div class="location-list">
                <?/*//php foreach ($driver->suburbs as $suburb): */?>
                    <div class="location-item"><?/*//= $suburb->title */?></div>
                <?/*//php endforeach; */?>
                 </div>
            -->
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
                            <h4>Deliveries</h4>
                            <h2 class="h1"><?php echo $deliveriesCount ?></h2>
                        </div>
                    </div>
                </div>
                <div class="border-top-item">
                    <div class="j_add_note_link <?php if(!$note['note']){ ?> hidden <?php } ?>">
                        <div class="note-block">
                            <div class="note-item"><?= $note['note']; ?></div>
                            <div class="note-button">
                                <span><a href="<?= \yii\helpers\Url::to(['drivers/note']) ?>?driverId=<?= $driver->id ?>" class="brown-text link-icon font-pencil j_colorbox">Edit Note</a></span>
                                <span><a href="#" class="brown-text link-icon font-delete-garbage-streamline j_note_delete" data-driverid="<?= $driverId; ?>">Delete</a></span>
                            </div>

                        </div>
                    </div>
                    <?php if ($reviews):?>
                        <h3 class="middle-gray-text">Reviews</h3>
                        <div class="company-list">
                            <?php foreach ($reviews as $review):?>
                                <div class="company-item">
                                    <h5><?= $review->store->title; ?></h5>
                                    <div><?php echo \kartik\rating\StarRating::widget(['value' => $review->stars]); ?></div>
                                    <div><?= $review->text; ?></div>
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
