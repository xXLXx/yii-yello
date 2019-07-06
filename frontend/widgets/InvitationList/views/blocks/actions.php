<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 26.06.2015
 * Time: 14:10
 */
use common\models\InvitationStatus;

/** @var \common\models\Invitation $invitation */

?>
<div class="edit-panel f-left">
    <?php if ($invitation->status->name == InvitationStatus::PENDING): ?>
        <a class="font-refresh red-text" href="#" title="Refresh"></a>
        <a class="font-delete-garbage-streamline red-text" href="#" title="Delete"></a>
    <?php endif; ?>
    <?php if ($invitation->status->name == InvitationStatus::REGISTRATION): ?>
        <a class="font-delete-garbage-streamline red-text f-right" href="#" title="Delete"></a>
    <?php endif; ?>
    <?php if ($invitation->status->name == InvitationStatus::CONNECTED): ?>
        <a class="font-link-broken red-text" href="#" title="Disconnect"></a>
        <a class="font-delete-garbage-streamline red-text" href="#" title="Delete"></a>
    <?php endif; ?>
</div>