<?php

namespace common\tests\fixtures;


use common\components\BaseFixture;


class SuburbFixture extends BaseFixture
{
    public $modelClass = 'common\models\Suburb';
    public $dataFile = '@common/tests/fixtures/data/Suburb.php';
} 