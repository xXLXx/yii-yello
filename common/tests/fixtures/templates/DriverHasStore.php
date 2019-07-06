<?php
use \Faker\Generator;
/**
 * @var Generator   $faker
 * @var integer     $index
 */
$faker->seed($index);
$created = $faker->dateTimeBetween("now -1 month", "now");
$updated = $faker->dateTimeBetween($created, "now +1 month");
$driverIds = \common\models\Driver::find()->select('User.id')->column();
if (empty($driverIds)) {
    echo "There are no Drivers to generate DriverHasStore fixture\n";
    return [];
}
$driverCount = max(count($driverIds), 1);
$driverNumber = $index % $driverCount;
$driverId = $driverIds[$driverNumber];
$storeIds = \common\models\Store::find()->select('Store.id')->column();
if (empty($storeIds)) {
    echo "There are no Stores to generate DriverHasStore fixture\n";
    return [];
}
$storeCount = max(count($storeIds), 1);
$storeNumber = $index % $storeCount;
$storeId = $storeIds[$storeNumber];

$alreadyExists = $index + 1 > $driverCount * $storeCount;
echo "$index. $driverCount * $storeCount = " . ($storeCount * $driverCount) . "\n";
if ($alreadyExists) {
    echo "Such invitation already exists" . PHP_EOL;
    return null;
}

return [
    'id' => $index + 1,
    'createdAt' => $created->getTimestamp(),
    'updatedAt' => $updated->getTimestamp(),
    'driverId' => $driverId,
    'storeId' => $storeId,
    'isInvitedByStoreOwner' => 1,
    'isAcceptedByDriver' => $faker->boolean(),
    'isArchived' => 0,
];