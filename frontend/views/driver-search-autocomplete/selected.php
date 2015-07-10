<?php
    use frontend\widgets\DriverSearchAutocompleteSelected\DriverSearchAutocompleteSelectedWidget;
?>

<?= 
    DriverSearchAutocompleteSelectedWidget::widget([
        'driverId' => $driver->id
    ]);
?>