<?php
use \Faker\Generator;
/**
 * @var Generator   $faker
 * @var integer     $index
 */
$faker->seed($index);
$created = $faker->dateTimeBetween("now -1 month", "now");
$shiftStateIds = \common\models\ShiftState::find()->select('ShiftState.id')->column();
if (empty($shiftStateIds)) {
    echo "There are no ShiftStates to generate ShiftStateLog fixture\n";
    return [];
}
$shiftStateCount = max(count($shiftStateIds), 1);
$shiftStateNumber = $index % $shiftStateCount;
$shiftStateId = $shiftStateIds[$shiftStateNumber];
$shiftIds = \common\models\Shift::find()->select('Shift.id')->column();
if (empty($shiftIds)) {
    echo "There are no Shifts to generate ShiftStateLog fixture\n";
    return [];
}
$shiftCount = max(count($shiftIds), 1);
$shiftNumber = $index % $shiftCount;
$shiftId = $shiftIds[$shiftNumber];

$alreadyExists = $index + 1 > $shiftStateCount * $shiftCount;
//echo "$index. $shiftStateCount * $shiftCount = " . ($shiftCount * $shiftStateCount) . "\n";
if ($alreadyExists) {
    echo "Such row already exists" . PHP_EOL;
    return null;
}

return [
    'id' => $index + 1,
    'createdAt' => $created->getTimestamp(),
    'shiftStateId' => $shiftStateId,
    'shiftId' => $shiftId,
    'isArchived' => 0,
];