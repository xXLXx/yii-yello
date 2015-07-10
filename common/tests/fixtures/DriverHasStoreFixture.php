<?php
/**
 * Shift fixture class
 */

namespace common\tests\fixtures;


use common\components\BaseFixture;

class DriverHasStoreFixture extends BaseFixture
{
    public $modelClass = 'common\models\DriverHasStore';
    public $dataFile = '@common/tests/fixtures/data/DriverHasStore.php';
    public $depends = [
        'common\tests\fixtures\UserDriverFixture',
        'common\tests\fixtures\StoreFixture',
    ];
}