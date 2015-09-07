<?php
use yii\helpers\Html;
?>
<div class="item no-border">
    <div class="user-photo-container f-left">
        <img src="/images/profile/<?= $user->id; ?>" alt="<?= $user->username ?>" />
    </div>
    <div class="user-photo-info">
        <span><?= \Yii::t('app', 'Hello') ?>, <?= $user->username ?></span>
        <span class="gray-text">
            <?= Html::a(Yii::t('app', 'Profile'), ['settings/index']); ?> / <?= Html::a(Yii::t('app', 'Logout'), ['site/logout']); ?>
        </span>
    </div>
</div>