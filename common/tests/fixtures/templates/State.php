<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'id'    => $index + 1,
    'title' => $faker->city,
    'countryId' => ($index % 50) + 1
];