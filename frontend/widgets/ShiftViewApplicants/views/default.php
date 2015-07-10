<?php

use frontend\widgets\ShiftViewApplicants\assets\ShiftViewApplicantsAsset;

ShiftViewApplicantsAsset::register($this);
?>
<div class="j_drivers_list">
    <h4>
        <span><?= \Yii::t('app', 'Applicants'); ?></span>
    </h4>
    <?php foreach ($applicants as $applicant): ?>
        <?= 
            $this->render('item', [
                'driver' => $applicant,
                'shift'  => $shift
            ]); 
        ?>
    <?php endforeach; ?>
</div>
<?= $this->registerJs('ShiftViewApplicantsWidget.init();'); ?>