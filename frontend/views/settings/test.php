<?php
use frontend\widgets;

use common\models\Role;
use frontend\widgets\UserEdit\UserEditWidget;
/* @var $this yii\web\View */
$this->title = \Yii::t('app', 'Test / Yello');
?>
<style>
    .sidebar-container:after {width:0;}
</style>
<div class="sidebar-container">
    <div class="col-right">
        <h2><?= $this->title ?></h2>
        
        The email code was run successfully. Mandrill has not returned a result to this server. Please check your email.
    </div>
</div>

