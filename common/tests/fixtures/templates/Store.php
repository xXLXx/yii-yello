<?php
use \Faker\Generator;
/**
 * @var Generator   $faker
 * @var integer     $index
 */
$faker->seed($index);
$start = $faker->dateTime;
$hours = rand(0, 5);
$minutes = rand(25, 59);
$created = $faker->dateTime;
$updated = $faker->dateTimeBetween($created, "now +1 month");
return [
    'id' => $index + 1,
    'title' => $faker->company,
    'createdAt' => $created->getTimestamp(),
    'updatedAt' => $updated->getTimestamp(),
    'isArchived' => 0,
    'address1' => $faker->address,
    'address2' => $faker->address,
    'contactPerson' => $faker->name,
    'phone' => $faker->phoneNumber,
    'website' => $faker->url,
    'email' => $faker->companyEmail,
];