<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie8"><![endif]-->
<!--[if gt IE 9]><!--><html><!--<![endif]-->
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!--[if IE 8]><script type="text/javascript" src="/js/css3-mediaqueries.js"></script><![endif]-->
</head>
<body>
    <?php $this->beginBody() ?>
        <div class="wrapper">
            <div class="login-block">
                <a class="logo" href="/" title="Yello">Yello</a>
                <div class="login-container">
                    <div class="login-bg">
                        <img src="/img/login-bg.jpg" alt="login-bg" />
                    </div>
                    <?= $content ?>
                </div>
            </div>
        </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
