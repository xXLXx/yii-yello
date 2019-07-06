<?php

namespace common\tests\fixtures;


use common\components\BaseFixture;


class CurrencyFixture extends BaseFixture
{
    public $modelClass = 'common\models\Currency';
    public $dataFile = '@common/tests/fixtures/data/Currency.json';
} 