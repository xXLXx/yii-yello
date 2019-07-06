<?php
/**
 * Shift fixture class
 */

namespace common\tests\fixtures;


use common\components\BaseFixture;

class StoreFixture extends BaseFixture
{
    public $modelClass = 'common\models\Store';
    public $dataFile = '@common/tests/fixtures/data/Store.php';
}