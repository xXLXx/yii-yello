<?php
use \Faker\Generator;
/**
 * @var Generator   $faker
 * @var integer     $index
 */
$faker->seed($index);
$start = $faker->dateTimeBetween("now", "now + 1 week");
$hours = rand(0, 5);
$minutes = rand(25, 59);
$created = $faker->dateTime;
$updated = $faker->dateTimeBetween($created, "now +1 month");
$shiftStateIds = \common\models\ShiftState::find()->select('id')->column();
$storeIds = \common\models\Store::find()->select('id')->column();
return [
    'id' => $index + 1,
    'start' => $start->format("Y-m-d H:i:s"),
    'end' => $start->add(new DateInterval("PT{$hours}H{$minutes}M"))->format("Y-m-d H:i:s"),
    'isVehicleProvided' => $faker->boolean() ? 1 : 0,
    'isYelloDrivers' => $faker->boolean() ? 1 : 0,
    'isMyDrivers' => $faker->boolean() ? 1 : 0,
    'isFavourites' => $faker->boolean() ? 1 : 0,    
    'approvedApplicationId' => $faker->md5,
    'createdAt' => $created->getTimestamp(),
    'updatedAt' => $updated->getTimestamp(),
    'isArchived' => $faker->boolean() ? 1 : 0,
    'storeId' => $storeIds[rand(0, count($storeIds) - 1)],
    'shiftStateId' => $shiftStateIds[rand(0, count($shiftStateIds) - 1)],
];