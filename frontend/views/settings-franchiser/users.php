<?php
use common\models\Role;
use frontend\widgets;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = \Yii::t('app', 'Manage Users');
?>

<div class="sidebar-container">
    <?= widgets\SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <h2 class="with-button inline-block"><?= $this->title ?></h2>
        
        <div class="toggle-popup-container j_toggle_container">
            <span class="btn blue small">
                <a class="j_toggle_link" href="javascript:;"><?= \Yii::t('app', 'Add user'); ?></a>
                <span class="btn blue small font-triangle-down j_toggle_link"></span>
            </span>
            <div class="info-popup j_toggle_block" style="display: none;">
                <?php foreach ($rolesAdd as $role): ?>
                    <a class="info-item" 
                        href="<?= Url::to(['franchiser-user-add/index', 'roleId' => $role->id]); ?>">
                        <?= \Yii::t('app', $role->title); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php foreach ($userGroups as $group): ?>
            <h5><?= $group['title'] ?></h5>
            <div class="users-list">
                <?php foreach ($group['users'] as $user): ?>
                    <div class="users-list-item">
                        <div class="user-photo-container">
                            <img src="<?= $user->image? $user->image->thumbUrl : '/img/shop_white_front.png' ?>" alt="<?= $user->firstName ?>" />
                        </div>
                        <?php if ($user->role->name == Role::ROLE_FRANCHISER_MANAGER_EXTENDED): ?>
                            <div class="user-role"><span><?= \Yii::t('app', 'Admin') ?></span></div>
                        <?php endif; ?>
                        <div class="user-panel-button">
                            <?= Html::a('', ['user/edit', 'userId' => $user->id], ['class' => 'font-pencil', 'title' => \Yii::t('app', 'Edit user')]) ?>
                            <?= Html::a('', ['user/delete', 'userId' => $user->id], ['class' => 'font-delete-garbage-streamline red-text', 'title' => \Yii::t('app', 'Delete user')]) ?>
                        </div>
                        <div class="user-title"><?= $user->username ?></div>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
