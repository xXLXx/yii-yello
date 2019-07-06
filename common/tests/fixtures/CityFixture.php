<?php

namespace common\tests\fixtures;


use common\components\BaseFixture;


class CityFixture extends BaseFixture
{
    public $modelClass = 'common\models\City';
    public $dataFile = '@common/tests/fixtures/data/City.php';
} 