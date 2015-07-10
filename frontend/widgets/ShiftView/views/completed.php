<?php

use frontend\widgets\ShiftViewActiveDriver\ShiftViewActiveDriverWidget;

?>

<h4><?= \Yii::t('app', 'Driver'); ?></h4>
<?php if ($shift->driverAccepted): ?>
    <?= 
        ShiftViewActiveDriverWidget::widget([
            'driverId' => $shift->driverAccepted->id
        ]);
    ?>
<?php endif; ?>
<?= 
    $this->render('blocks/completed/footer', [
        'shift'    => $shift
    ]);
?>