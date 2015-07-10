<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 25.06.2015
 * Time: 17:07
 */
use frontend\widgets\StoresList\StoresListWidget;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var ActiveDataProvider $dataProvider */
/** @var int $storesCount all stores count */


$this->title = "Stores";
?>
<div class="wrapper j_fix_header">
    <div class="content clearfix">
        <div class="header-panel">
            <div class="inline-header-block">
                <h2><?= Html::encode($this->title) ?></h2>
            </div>
            <form action="" method="get" class="j_stores-filter-form">
                <div class="inline-header-block f-right">
                <!--<div class="filter-btn">
                    <div class="item active">Active</div>
                    <div class="item">Archived</div>
                </div>
                <div class="toggle-popup-container j_toggle_container">
                    <a class="btn blue small j_toggle_link">
                        <span class="font-filter"></span>
                        Filter
                    </a>
                    <div class="toggle-popup width-326 j_toggle_block">
                        <table class="profile-settings">
                            <col width="40%"/>
                            <tr>
                                <td>
                                    <label>Schedule</label>
                                    <div>
                                        <div class="checkbox-input"><input id="schedule-1" value="" type="checkbox" checked="checked"><label class="j_checkbox active" for="schedule-1">1</label></div>
                                        <div class="checkbox-input"><input id="schedule-5" value="" type="checkbox" checked="checked"><label class="j_checkbox active" for="schedule-5">5</label></div>
                                        <div class="checkbox-input"><input id="schedule-2" value="" type="checkbox"><label class="j_checkbox" for="schedule-2">2</label></div>
                                        <div class="checkbox-input"><input id="schedule-6" value="" type="checkbox" checked="checked"><label class="j_checkbox active" for="schedule-6">6</label></div>
                                        <div class="checkbox-input"><input id="schedule-3" value="" type="checkbox" disabled="disabled"><label class="disabled" for="schedule-3">3</label></div>
                                        <div class="checkbox-input"><input id="schedule-7" value="" type="checkbox" checked="checked"><label class="j_checkbox active" for="schedule-7">7</label></div>
                                        <div class="checkbox-input"><input id="schedule-4" value="" type="checkbox" checked="checked" disabled="disabled"><label class="active disabled" for="schedule-4">4</label></div>
                                    </div>
                                </td>
                                <td>
                                    <label>Rating</label>
                                    <div class="j_radio_container">
                                        <div class="radio-input"><input id="rating-1" name="rating" value="" type="radio" checked="checked"><label class="j_radio active" for="rating-1">Doesn't matter</label></div>
                                        <div class="clear"></div>
                                        <div class="radio-input"><input id="rating-2" name="rating" value="" type="radio"><label class="j_radio" for="rating-2">1 star</label></div>
                                        <div class="clear"></div>
                                        <div class="radio-input"><input id="rating-3" name="rating" value="" type="radio" disabled="disabled"><label class="disabled" for="rating-3">2 stars</label></div>
                                        <div class="clear"></div>
                                        <div class="radio-input"><input id="rating-4" name="rating2" value="" type="radio" checked="checked" disabled="disabled"><label class="disabled active" for="rating-4">3 stars</label></div>
                                        <div class="clear"></div>
                                        <div class="radio-input"><input id="rating-5" name="rating" value="" type="radio"><label class="j_radio" for="rating-5">More than 4 stars</label></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>-->
<!--                <a href="--><?//= \yii\helpers\Url::to('/stores-franchiser/request') ?><!--" class="j_colorbox">-->
                    <input id="search" class="text-input small search" type="text" name="query" placeholder="Search"
                        <?php if (!empty($searchParams['query'])): ?>
                            value="<?= $searchParams['query'] ?>"
                        <?php endif; ?>
                    />
<!--                </a>-->
            </div>
            </form>
        </div>

        <div class="header-panel-results">
            <div class="inline-header-block">
                <?php if (!empty($searchParams['query'])): ?>
                    <div><b><?= $dataProvider->totalCount ?></b> Stores found for: "<?= $searchParams['query'] ?>"</div>
                <?php else: ?>
                    <div><b><?= $dataProvider->totalCount ?></b> Stores found</div>
                <?php endif; ?>

            </div>
            <!--<div class="inline-header-block">
                <div class="inline-block">Filter option:</div>
                <div class="inline-block">
                    <div class="label">
                        Shedile: 1, 2
                        <a href="#" class="round-btn font-x"></a>
                    </div>
                    <div class="label">
                        Minimal rating: 2
                        <a href="#" class="round-btn font-x"></a>
                    </div>
                </div>
                <div class="inline-block"><a href="#">Clear filter</a></div>
            </div>-->
        </div>

        <?= StoresListWidget::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'border-table align-top'],
        ]); ?>
    </div>
</div>
