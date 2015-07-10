<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 26.06.2015
 * Time: 11:52
 */

use frontend\widgets\InvitationList\InvitationListWidget;
use frontend\widgets\SettingsLeftNavigation;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\web\View;

/** @var View $this */
/** @var ActiveDataProvider $dataProvider */
/** @var array $searchParams */
$this->title = \Yii::t('app', 'Invitations');
?>
<div class="sidebar-container">
    <?= SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <div class="f-right">
            <a href="<?= Url::to('/stores-franchiser/request') ?>" class="btn blue small j_colorbox cboxElement"><span class="round-btn font-plus white"></span>Invite</a>
        </div>
        <form action="" class="inline-block-list" method="get">
            <h2><?= $this->title ?></h2>
            <input type="text" class="text-input small search j_placeholder placeholder" alt="Search" name="query"
            <?php if (!empty($searchParams['query'])): ?>
                value="<?= $searchParams['query'] ?>"
            <?php endif; ?>
            />
        </form>
        <div class="header-panel-results j_search_link">
            <div class="inline-header-block">
                <?php if (!empty($searchParams['query'])): ?>
                <div><b><?= $dataProvider->totalCount ?></b> Results found for: "<?= $searchParams['query'] ?>"</div>
                <?php else: ?>
                    <div><b><?= $dataProvider->totalCount ?></b> Results found</div>
                <?php endif; ?>
            </div>
            <div class="inline-header-block">
                <div class="inline-block"><a href="<?= Url::to('/settings-franchiser/invitations') ?>">Clear Search Results</a></div>
            </div>
        </div>

        <?= InvitationListWidget::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'border-table align-top'],
        ]); ?>
    </div>
</div>
