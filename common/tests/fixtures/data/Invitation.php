<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 26.06.2015
 * Time: 13:47
 */

use common\models\InvitationStatus;

$data = [];

$name = 'name';
$email = 'mail@mail.ru';
$created = 850009644;
$updated = 1269370839;
$deleted = 0;

$statuses = InvitationStatus::find()->all();

foreach (range(1, 100) as $i) {
    $data[] = [
        'id' => $i,
        'name' => $name . $i,
        'email' => $email . $i,
        'statusId' => $statuses[$i%3]->id,
        'createdAt' => $created,
        'updatedAt' => $updated,
        'isArchived' => $deleted,
    ];
    $updated += 100000;
    $created += 10000;
}

return $data;