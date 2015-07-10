<?php
use \Faker\Generator;
/**
 * @var Generator   $faker
 * @var integer     $index
 */
$faker->addProvider(new common\Faker\Provider\Image($faker));
$created = $faker->dateTime;
$updated = $faker->dateTimeBetween($created, "now +1 month");
return [
    'id' => $index + 1,
    'createdAt' => $created->getTimestamp(),
    'updatedAt' => $updated ->getTimestamp(),
    'isArchived' =>  0,
    'originalUrl' => $faker->image(\Yii::$app->basePath . '/../frontend/web/upload/images', 600, 480, 'cats', false, '/upload/images/'),
    'largeUrl' => $faker->image(\Yii::$app->basePath . '/../frontend/web/upload/images', 800, 600, 'cats', false, '/upload/images/'),
    'thumbUrl' => $faker->image(\Yii::$app->basePath . '/../frontend/web/upload/images', 144, 144, 'cats', false, '/upload/images/'),
//    'originalUrl' => $faker->imageUrl(600, 480, 'cats'),
//    'largeUrl' => $faker->imageUrl(800, 600, 'cats'),
//    'thumbUrl' => $faker->imageUrl(144, 144, 'cats'),
    'title' => 'cats',
    'alt' => 'cats'
];