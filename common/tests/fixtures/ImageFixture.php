<?php

namespace common\tests\fixtures;


use common\components\BaseFixture;


class ImageFixture extends BaseFixture
{
    public $modelClass = 'common\models\Image';
    public $dataFile = '@common/tests/fixtures/data/Image.php';
} 