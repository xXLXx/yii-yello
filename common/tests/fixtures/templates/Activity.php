<?php
use \Faker\Generator;
/**
 * @var Generator   $faker
 * @var integer     $index
 */
$now = new \DateTime();
$now->sub(new \DateInterval('PT' . ($index + rand(1, 3)) . 'H'));
$created = $now;
$updated = $created;

$names = [
    'ShiftAddApplicant', 
    'ShfitAcceptedByStoreOwner', 
    'ShiftDeliveryCount', 
    'ShiftPayment'
];

return [
    'name'       => $names[($index % 4)],
    'userId'     => 2,
    'createdAt'  => $created->getTimestamp(),
    'updatedAt'  => $updated->getTimestamp(),
    'isArchived' => 0
];
