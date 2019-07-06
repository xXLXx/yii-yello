<?php

$name = $faker->city;

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'id'        => $index + 1,
    'name'      => '',
    'title'     => $name,
    'stateId'   => ($index % 50) + 1
];