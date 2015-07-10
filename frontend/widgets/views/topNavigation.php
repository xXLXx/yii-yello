<?php
/**
 * @var $date string
 * @var $time string
 * @var $user \common\models\User
 * @var $menuItems array
 * @var $context frontend\widgets\TopNavigation
 */
use yii\helpers\Html;
use frontend\widgets\UserMenu\UserMenuWidget;
?>

<div class="header clearfix">
    <div class="f-left">
        <div class="logo-container">
            <?= Html::a(Yii::t('app', 'Yello'), ['/'], ['class' => 'logo']); ?>
        </div>
        <div class="date-info"><span class="gray-text"><?= $date ?> </span><?= $time ?></div>
        <div class="main-menu">
            <?php foreach( $menuItems as $item ): ?>

                <?= Html::a($item['label'], $item['url'], [
                    'class' => $context->getItemClass($item['class'], $item['url']),
                ]); ?>

            <?php endforeach; ?>
        </div>
    </div>
    <?php if ($user):?>
        <div class="f-right">
            <?= UserMenuWidget::widget(['user' => $user]) ?>
        </div>
    <?php endif; ?>
</div>