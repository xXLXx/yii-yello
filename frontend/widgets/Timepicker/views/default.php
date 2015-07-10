<?php

    use yii\helpers\Html;
    
    use frontend\widgets\Timepicker\assets\TimepickerAsset;
    
    TimepickerAsset::register($this);
?>

<?= Html::textInput($name, $value, $options); ?>

<?php
    $this->registerJs("TimepickerWidget.init('{$options['id']}');");
?>