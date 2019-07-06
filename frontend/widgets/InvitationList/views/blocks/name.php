<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 26.06.2015
 * Time: 14:10
 */

/** @var \common\models\Invitation $invitation */

?>
<span class="bold-text"><?= $invitation->name ?></span>
<div class="gray-text">Invited: <?= (new \DateTime($invitation->createdAtAsDateTime))->format('d M, Y') ?></div>