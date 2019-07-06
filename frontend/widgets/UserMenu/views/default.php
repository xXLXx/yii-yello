<?php
use frontend\widgets\StoreSwitch\StoreSwitchWidget;
use frontend\widgets\UserProfile\UserProfileWidget;
?>
<div class="user-menu">
    <?= UserProfileWidget::widget(['user' => $user])?>
    <?= StoreSwitchWidget::widget(['user' => $user])?>
</div>