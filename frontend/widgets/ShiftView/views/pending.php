<?php

use frontend\widgets\ShiftViewApplicants\ShiftViewApplicantsWidget;

?>

<?= 
    ShiftViewApplicantsWidget::widget([
        'shiftId' => $shift->id
    ]); 
?>
<?php if (!$shift->applicants): ?>
    <div>
        <div class="center loading-block">
            <span style="cursor:pointer;" 
                class="loading-inner gray-text"><?= \Yii::t('app', 'Pending applications') ?>...</span>
        </div>
    </div>
<?php endif; ?>
