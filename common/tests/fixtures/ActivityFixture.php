<?php
/**
 * Activity fixture class
 */

namespace common\tests\fixtures;


use common\components\BaseFixture;

class ActivityFixture extends BaseFixture
{
    public $modelClass = 'common\models\Activity';
    public $dataFile = '@common/tests/fixtures/data/Activity.php';
}