<?php

use frontend\widgets\ShiftViewDriverAccepted\ShiftViewDriverAcceptedWidget;

?>

<h4><?= \Yii::t('app', 'Driver'); ?></h4>
<?= 
    ShiftViewDriverAcceptedWidget::widget([
        'shift' => $shift
    ]);
?>