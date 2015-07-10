<?php
/**
 * ShiftStateLog fixture class
 */

namespace common\tests\fixtures;


use common\components\BaseFixture;

class ShiftStateLogFixture extends BaseFixture
{
    public $modelClass = 'common\models\ShiftStateLog';
    public $dataFile = '@common/tests/fixtures/data/ShiftStateLog.php';
    public $depends = [
        'common\tests\fixtures\ShiftFixture',
//        'common\tests\fixtures\ShiftStateFixture',
    ];
}