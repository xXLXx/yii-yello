<?php

namespace common\tests\fixtures;


use common\components\BaseFixture;


class CountryFixture extends BaseFixture
{
    public $modelClass = 'common\models\Country';
    public $dataFile = '@common/tests/fixtures/data/Country.json';
} 