<div class="middle-gray-text">#<?= $shift->id; ?></div>
<div class="calendar-shift-detail-list">
    <div class="calendar-shift-detail-item icon-calendar-2">
        <h3><?= \Yii::$app->formatter->asDate($shift->start, 'd MMMM, Y'); ?></h3>
    </div>
    <div class="calendar-shift-detail-item icon-alarm-clock">
        <div class="inline-block">
            <h4><?= \Yii::t('app', 'Start'); ?></h4>
            <h3 class="bold-text"><?= date('g:ia', strtotime($shift->start)); ?></h3>
        </div>
        <div class="inline-block">
            <h4><?= \Yii::t('app', 'End'); ?></h4>
            <h3 class="bold-text"><?= date('g:ia', strtotime($shift->end)); ?></h3>
        </div>
        <?php if ($shift->actualStart): ?>
            <h4><?= \Yii::t('app', 'Actual time') ?></h4>
            <div class="inline-block">
                <h3 class="bold-text green-text">
                    <?= date('g:ia', strtotime($shift->actualStart)); ?>
                </h3>
            </div>
            <?php if ($shift->actualEnd): ?>
                <div class="inline-block">
                    <h3 class="bold-text red-text">
                        <?= date('g:ia', strtotime($shift->actualEnd)); ?>
                    </h3>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    <div class="calendar-shift-detail-item icon-truck-1">
        <?php if ($shift->isVehicleProvided): ?>
            <?= \Yii::t('app', 'Provided'); ?>
        <?php else: ?>
            <?= \Yii::t('app', 'Driver Owned'); ?>
        <?php endif; ?>
    </div>
    <?php if ($shift->visibleGroupNames): ?> 
        <div class="calendar-shift-detail-item icon-contacts-2">
            <?= $shift->visibleGroupNames; ?>
        </div>
    <?php endif; ?>
</div>