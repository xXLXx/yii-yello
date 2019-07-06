<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
$pos = strpos($name, '404');
if($pos !== false){
    $notFound = true;
}else{
    $notFound = false;
}
?>
<div class="site-error">

    <h1><?= 'Oops, sorry we seem to have had an accident.' ?></h1>

    <?php if($notFound === false){?>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

    <?php } ?>
    <p>
        Click on the following button to redirect to Drive Yello Home.
    </p>
    <?= Html::a('Drive Yello', Yii::$app->urlManager->createUrl('site/index'), ['class' => 'btn']) ?>


</div>
