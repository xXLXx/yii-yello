<?php
/**
 * ShiftRequestReview fixture class
 */

namespace common\tests\fixtures;


use common\components\BaseFixture;

class ShiftRequestReviewFixture extends BaseFixture
{
    public $modelClass = 'common\models\ShiftRequestReview';
    public $dataFile = '@common/tests/fixtures/data/ShiftRequestReview.php';
    public $depends = [
        'common\tests\fixtures\ShiftFixture',
    ];
}