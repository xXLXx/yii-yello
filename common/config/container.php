<?php

//Yii::$container->set('kartik\rating\StarRating', [
Yii::$container->set('frontend\widgets\StarRating\StarRating', [
    'name' => 'rating_2',
    'disabled' => true,
    'pluginOptions' => [
        'showClear' => false,
        'size'  => 'xs',
        'showCaption' => false,
        'glyphicon' => false,
        'ratingClass' => 'star-block big'
    ]
]);