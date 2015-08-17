<?php

use yii\helpers\Url;
use frontend\widgets\DriverList\DriverListWidget;

use frontend\assets\DriversAsset;

DriversAsset::register($this);

$this->title = \Yii::t('app', 'Drivers');

$this->registerJs('$(function(){DriversFilter.init(); AddFavouriteDriver.init(); StoreInviteDriverController.init();})');
?>
        <div class="header-panel">
            <div class="inline-header-block align-top">
                <h2><?= $this->title ?></h2>
            </div>
            <div class="inline-header-block align-top j_driver_search">
                <div class="filter-btn">
                    <label for="category-all" class="item
                        <?php if (empty($searchParams['category']) || $searchParams['category'] == 'all'): ?>
                            active
                        <?php endif; ?>">
                        <a href="?category=all"><?= \Yii::t('app', 'All Drivers') ?></a>
                    </label>
                    <label for="category-my" class="item
                        <?php if (!empty($searchParams['category']) && $searchParams['category'] == 'my'): ?>
                            active
                        <?php endif; ?>">
                        <a href="?category=my"><?= \Yii::t('app', 'My Drivers') ?></a>
                    </label>
                    <label for="category-favourites" class="item
                        <?php if (!empty($searchParams['category']) && $searchParams['category'] == 'favourites'): ?>
                            active
                        <?php endif; ?>">
                        <a href="?category=favourites"><?= \Yii::t('app', 'Favourites') ?></a>
                    </label>
                </div>
                <div class="inline-header-block">
                    <form class="j_driver-filter-form" action="" method="get">
                        <input
                            <?php if (!empty($searchParams['category']) && $searchParams['category'] == 'all'): ?>
                                checked="checked"
                            <?php endif; ?>
                            class="hidden j_no-reset" id="category-all" type="radio" name="category" value="all"/>
                        <input
                            <?php if (!empty($searchParams['category']) && $searchParams['category'] == 'my'): ?>
                                checked="checked"
                            <?php endif; ?>
                            class="hidden j_no-reset" id="category-my" type="radio" name="category" value="my"/>
                        <input
                            <?php if (!empty($searchParams['category']) && $searchParams['category'] == 'favourites'): ?>
                                checked="checked"
                            <?php endif; ?>
                            class="hidden j_no-reset" id="category-favourites" type="radio" name="category" value="favourites"/>
                    <div class="toggle-popup-container j_toggle_container">
                        <a class="btn blue small j_toggle_link">
                            <span class="font-filter"></span>
                            <?= \Yii::t('app', 'Filter') ?>
                        </a>
                        <div class="toggle-popup width-326 j_toggle_block">
                            <table class="profile-settings">
                                <col width="40%"/>
                                <tr>
                                    <td>
                                        <label><?= \Yii::t('app', 'Vehicle type') ?></label>
                                        <div>
                                            <div class="checkbox-input">
                                                <input
                                                    <?php if (!empty($searchParams['vehicle'])
                                                            && in_array('car', $searchParams['vehicle'])): ?>
                                                        checked="checked"
                                                    <?php endif; ?>
                                                    id="schedule-1" name="vehicle[]" value="car" type="checkbox">
                                                <label class="j_filter-checkbox
                                                    <?php if (!empty($searchParams['vehicle'])
                                                            && in_array('car', $searchParams['vehicle'])): ?>
                                                             active
                                                    <?php endif; ?>" for="schedule-1">
                                                    <?= \Yii::t('app', 'Car') ?>
                                                </label>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="checkbox-input">
                                                <input
                                                    <?php if (!empty($searchParams['vehicle'])
                                                            && in_array('bike', $searchParams['vehicle'])): ?>
                                                        checked="checked"
                                                    <?php endif; ?>
                                                    id="schedule-5" name="vehicle[]" value="bike" type="checkbox">
                                                <label class="j_filter-checkbox
                                                    <?php if (!empty($searchParams['vehicle'])
                                                            && in_array('bike', $searchParams['vehicle'])): ?>
                                                        active
                                                    <?php endif; ?>" for="schedule-5">
                                                    <?= \Yii::t('app', 'Bike') ?>
                                                </label>
                                             </div>
                                        </div>
                                        <br/>
                                        <?php /*
                                        <label><?= \Yii::t('app', 'Availability') ?></label>
                                        <div>
                                            <div class="checkbox-input">
                                                <input
                                                    <?php if (!empty($searchParams['availability'])
                                                            && in_array('shift', $searchParams['availability'])): ?>
                                                        checked="checked"
                                                    <?php endif; ?>
                                                    id="schedule-6" name="availability[]" value="shift" type="checkbox">
                                                <label class="j_filter-checkbox
                                                    <?php if (!empty($searchParams['availability'])
                                                            && in_array('shift', $searchParams['availability'])): ?>
                                                        active
                                                    <?php endif; ?>" for="schedule-6">
                                                    <?= \Yii::t('app', 'Shift') ?>
                                                </label>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="checkbox-input">
                                                <input
                                                    <?php if (!empty($searchParams['availability'])
                                                            && in_array('roamer', $searchParams['availability'])): ?>
                                                        checked="checked"
                                                    <?php endif; ?>
                                                    id="schedule-7" name="availability[]" value="roamer" type="checkbox">
                                                <label class="j_filter-checkbox
                                                    <?php if (!empty($searchParams['availability'])
                                                            && in_array('roamer', $searchParams['availability'])): ?>
                                                        active
                                                    <?php endif; ?>" for="schedule-7">
                                                    <?= \Yii::t('app', 'Roamer') ?>
                                                </label>
                                            </div>
                                        </div>
                                        <?php */ ?>
                                    </td>
                                    <td>
                                        <label><?= \Yii::t('app', 'Rating') ?></label>
                                        <div class="j_radio_container">
                                            <div class="radio-input">
                                                <input
                                                    <?php if (empty($searchParams['rating'])): ?>
                                                        checked="checked"
                                                    <?php endif; ?>
                                                    id="rating-1" name="rating" value="0" type="radio">
                                                <label class="j_radio
                                                    <?php if (empty($searchParams['rating'])): ?>
                                                        active
                                                    <?php endif; ?>" for="rating-1">
                                                    <?= \Yii::t('app', 'Doesn\'t matter') ?>
                                                </label>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="radio-input">
                                                <input
                                                    <?php if (!empty($searchParams['rating']) && $searchParams['rating'] == 1): ?>
                                                        checked="checked"
                                                    <?php endif; ?>
                                                    id="rating-2" name="rating" value="1" type="radio">
                                                <label class="j_radio
                                                    <?php if (!empty($searchParams['rating']) && $searchParams['rating'] == 1): ?>
                                                        active
                                                    <?php endif; ?>" for="rating-2">
                                                    <?= \Yii::t('app', '1 star') ?>
                                                </label>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="radio-input">
                                                <input
                                                    <?php if (!empty($searchParams['rating']) && $searchParams['rating'] == 2): ?>
                                                        checked="checked"
                                                    <?php endif; ?>
                                                    id="rating-3" name="rating" value="2" type="radio">
                                                <label class="j_radio
                                                    <?php if (!empty($searchParams['rating']) && $searchParams['rating'] == 2): ?>
                                                        active
                                                    <?php endif; ?>" for="rating-3">
                                                    <?= \Yii::t('app', '2 stars') ?>
                                                </label>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="radio-input">
                                                <input
                                                    <?php if (!empty($searchParams['rating']) && $searchParams['rating'] == 3): ?>
                                                        checked="checked"
                                                    <?php endif; ?>
                                                    id="rating-4" name="rating" value="3" type="radio">
                                                <label class="j_radio
                                                    <?php if (!empty($searchParams['rating']) && $searchParams['rating'] == 3): ?>
                                                        active
                                                    <?php endif; ?>" for="rating-4">
                                                    <?= \Yii::t('app', '3 star') ?>
                                                </label>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="radio-input">
                                                <input
                                                    <?php if (!empty($searchParams['rating']) && $searchParams['rating'] == 4): ?>
                                                        checked="checked"
                                                    <?php endif; ?>
                                                    id="rating-5" name="rating" value="4" type="radio">
                                                <label class="j_radio
                                                    <?php if (!empty($searchParams['rating']) && $searchParams['rating'] == 4): ?>
                                                        active
                                                    <?php endif; ?>" for="rating-5">
                                                    <?= \Yii::t('app', 'More than 4 stars') ?>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input name="searchText" id="search" class="text-input small search" type="text" alt="Search" placeholder="Search"
                        <?php if (!empty($searchParams['searchText'])): ?>
                            value="<?= $searchParams['searchText'] ?>"
                        <?php endif; ?>
                        />

                    </form>
                </div>
            </div>
            <div class="f-right">
                <a href="<?= Url::to(['store-invite-driver/index']) ?>" class="btn blue small j_colorbox">
                    <span class="round-btn font-plus white"></span><?= \Yii::t('app', 'Invite Driver') ?>
                </a>
            </div>
        </div>
        <div class="header-panel-results j_search_link">
            <div class="inline-header-block">
                <div>
                    <strong><?= $driversCount ?></strong> <?= \Yii::t('app', 'Drivers found') ?>
                    <?php if (!empty($searchParams['name'])): ?>
                        <?= \Yii::t('app', 'for: "') ?><?= $searchParams['name'] ?>"
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($searchParams['vehicle'])
                    || !empty($searchParams['availability'])
                    || !empty($searchParams['rating'])): ?>
            <div class="inline-header-block">
                <div class="inline-block"><?= \Yii::t('app', 'Filter option:') ?></div>
                <div class="inline-block">
                    <?php if (!empty($searchParams['vehicle'])): ?>
                        <?php foreach ($searchParams['vehicle'] as $vehicle): ?>
                            <div class="label">
                                <?= \Yii::t('app', 'Vehicle:') ?> <?= ucfirst($vehicle) ?>
                                <a href="#" class="round-btn font-x j_driver-filter-item-remove" data-val="<?= $vehicle ?>"></a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (!empty($searchParams['availability'])): ?>
                        <?php foreach ($searchParams['availability'] as $availability): ?>
                            <div class="label">
                                <?= \Yii::t('app', 'Availability:') ?> <?= ucfirst($availability) ?>
                                <a href="#" class="round-btn font-x j_driver-filter-item-remove" data-val="<?= $availability ?>"></a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (!empty($searchParams['rating'])): ?>
                        <div class="label">
                            <?= \Yii::t('app', 'Minimal rating:') ?> <?= $searchParams['rating'] ?>
                            <a href="#" class="round-btn font-x j_driver-filter-item-remove" data-val="<?= $searchParams['rating'] ?>"></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="inline-block"><a href="#" class="j_driver-filter-clear"><?= \Yii::t('app', 'Clear filter') ?></a></div>
            </div>
            <?php endif ?>
        </div>

        <?=
        DriverListWidget::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'border-table big-padding align-top j_driver_search'],
        ]);
        ?>

<!--        <div class="pagination clearfix j_driver_search">-->
<!--            <span class="font-chevron-left arrow"></span>-->
<!--            <a href="#" class="font-chevron-left arrow"></a>-->
<!--            <a href="#">1</a>-->
<!--            <a href="#">2</a>-->
<!--            <a href="#">3</a>-->
<!--            <span class="active">4</span>-->
<!--            <span>...</span>-->
<!--            <a href="#">8</a>-->
<!--            <a href="#" class="font-chevron-right arrow"></a>-->
<!--            <span class="font-chevron-right arrow"></span>-->
<!--        </div>-->
<!--        <div class="loading-block height-245 center j_driver_search" style="display:none;">-->
<!--            <h3 class="loading-inner gray-text">Sorry, No matches found.</h3>-->
<!--        </div>-->