<?php

namespace frontend\widgets\StarRating;

use frontend\widgets\StarRating\assets\StarRatingAsset;

class StarRating extends \kartik\rating\StarRating
{

    public $name = "StarRating";

    public function init()
    {
        parent::init();
    }

    public function registerAssets()
    {
        $view = $this->getView();

        StarRatingAsset::register($view);
        $this->registerPlugin('rating');
    }
}