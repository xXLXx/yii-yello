<?php

namespace frontend\widgets\StarRating\assets;

class StarRatingAsset extends \frontend\widgets\StarRating\assets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath('@vendor/kartik-v/bootstrap-star-rating');
        $this->setupAssets('css', ['css/star-rating']);
        $this->setupAssets('js', ['js/star-rating']);
        parent::init();
    }
}
