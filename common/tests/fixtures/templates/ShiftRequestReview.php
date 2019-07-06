<?php
use \Faker\Generator;
/**
 * @var Generator   $faker
 * @var integer     $index
 */
$faker->seed($index);
$created = $faker->dateTimeBetween("now -1 month", "now");
$updated = $faker->dateTimeBetween($created, "now +1 month");
$shiftIds = \common\models\Shift::find()->select('Shift.id')->column();
if (empty($shiftIds)) {
    echo "There are no Shifts to generate this fixture\n";
    return [];
}
$shiftCount = max(count($shiftIds), 1);
$shiftNumber = $index % $shiftCount;
$shiftId = $shiftIds[$shiftNumber];

$alreadyExists = $index + 1 > $shiftCount;
if ($alreadyExists) {
    echo "Such ShiftRequestReview already exists. Please specify another count param and run me again" . PHP_EOL;
    return null;
}

return [
    'id' => $index + 1,
    'createdAt' => $created->getTimestamp(),
    'updatedAt' => $updated->getTimestamp(),
    'shiftId' => $shiftId,
    'title' => $faker->realText(255),
    'text' => $faker->text(1024),
    'isArchived' => 0,
];