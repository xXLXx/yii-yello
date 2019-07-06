<ul class="color-list inline-list gray-text js-shift-states-count">
    <li class="bold js-total"><span class="count"></span> <?= \Yii::t('app', 'Total Shifts'); ?></li>
    <?php foreach ($states as $state): ?>
        <li class="js-state-count <?= $state->color ?> js-state-id-<?= $state->id ?>">
            <?= \Yii::t('app', $state->title); ?> (<span class="count"></span>)
        </li>
    <?php endforeach; ?>
</ul>