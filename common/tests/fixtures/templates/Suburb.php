<?php

$name = $faker->firstName;

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'id'        => $index + 1,
    'name'      => '',
    'title'     => $name,
    'cityId'   => ($index % 50) + 1
];