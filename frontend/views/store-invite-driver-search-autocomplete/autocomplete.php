<?php foreach ($drivers as $driver): ?>
    <?= 
        $this->render('autocomplete/item', [
            'driver' => $driver
        ]); 
    ?>
<?php endforeach; ?>