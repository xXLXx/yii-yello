<?php

namespace common\tests\fixtures;


use common\components\BaseFixture;


class TimeZoneFixture extends BaseFixture
{
    public $modelClass = 'common\models\TimeZone';
    public $dataFile = '@common/tests/fixtures/data/TimeZone.json';
} 