<?php
/**
 * Shift fixture class
 */

namespace common\tests\fixtures;


use common\components\BaseFixture;

class ShiftFixture extends BaseFixture
{
    public $modelClass = 'common\models\Shift';
    public $dataFile = '@common/tests/fixtures/data/Shift.php';
}