<?php
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
            <a type="button" class="btn blue small" href="<?= Url::to(['store-owner-user-add/index']); ?>">Add User</a>
        </div>
        <?php foreach ($userGroups as $group): ?>
            <h5><?= $group['title'] ?></h5>
            <div class="users-list">
                <?php foreach ($group['users'] as $user): ?>
                    <div class="users-list-item">
                        <div class="user-photo-container">
                            <img src="<?= $user->image? $user->image->thumbUrl : '/img/temp/02.jpg' ?>" alt="<?= $user->firstName ?>" />
                        </div>
                        <?php if ($user->role->name == 'yelloAdmin'): ?>
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
