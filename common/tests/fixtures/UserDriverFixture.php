<?php

namespace common\tests\fixtures;


use common\components\BaseFixture;


class UserDriverFixture extends BaseFixture
{
    public $modelClass = 'common\models\UserDriver';
    public $dataFile = '@common/tests/fixtures/data/UserDriver.php';
}