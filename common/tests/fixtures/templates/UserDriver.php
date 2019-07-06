<?php
use \Faker\Generator;
/**
 * @var Generator   $faker
 * @var integer     $index
 */
$faker->seed($index);

$faker->addProvider(new common\Faker\Provider\Image($faker));
$created = $faker->dateTime;
$updated = $faker->dateTimeBetween($created, "now +1 month");
return [
    'id' => $index + 1,
    'driverLicenseNumber' => $faker->randomNumber,
    'driverLicensePhoto' => $faker->imageUrl(640, 480, 'abstract'),
    'cityId' => rand(0, 50),
    'personalProfile' => $faker->word,
    'emergencyContactName' => $faker->firstName,
    'emergencyContactPhone' => $faker->phoneNumber,
    'availability' => $faker->boolean() ? 'shift' : 'roamer',
    'isAllowedToWorkInAustralia' => $faker->boolean() ? 1 : 0,
    'isAccredited' => $faker->boolean() ? 1 : 0,
    'paymentMethod' => $faker->word,
    'rating' => rand(0, 100),
    'status' => $faker->word,
    'isArchived' => 0,
    'userId' => rand(0, 50)
];