<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 26.06.2015
 * Time: 14:10
 */
use common\models\InvitationStatus;

/** @var InvitationStatus $status */

if (!function_exists('getSpanClassForStatus')) {
    function getSpanClassForStatus(InvitationStatus $status) {
        switch($status->name) {
            case InvitationStatus::PENDING:
                return 'red-text';
            case InvitationStatus::CONNECTED:
                return 'green-text';
            case InvitationStatus::REGISTRATION:
                return 'orange-text';
        }
    }
}
?>
<span class="<?= getSpanClassForStatus($status) ?>"><?= $status->name ?></span>