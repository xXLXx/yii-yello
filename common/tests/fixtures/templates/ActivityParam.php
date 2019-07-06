<?php
use \Faker\Generator;
/**
 * @var Generator   $faker
 * @var integer     $index
 */
$faker->seed($index);
$created = $faker->dateTimeBetween("now - 1 year", "now");
$updated = $created;

$fields = [
    'payment', 'deliveryCount', 'driverId', 'shiftId'
];

return [
    'activityId' => ($index % 9999) + 1,
    'value'      => rand(1, 100),
    'field'      => $fields[(($index + 2) % 4)],
    'createdAt'  => $created->getTimestamp(),
    'updatedAt'  => $updated->getTimestamp(),
    'isArchived' => 0
];
