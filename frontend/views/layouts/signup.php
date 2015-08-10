<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\Widget;

/* @var $this \yii\web\View */
/* @var $content string */
BootstrapAsset::register($this);
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

<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" sizes="57x57" href="/img/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon" sizes="114x114" href="/img/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon" sizes="72x72" href="/img/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="144x144" href="/img/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon" sizes="60x60" href="/img/apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon" sizes="120x120" href="/img/apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon" sizes="76x76" href="/img/apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon" sizes="152x152" href="/img/apple-touch-icon-152x152.png" />
<link rel="shortcut iconicon" type="image/png" href="/img/favicon-16x16.png" sizes="16x16" />
<link rel="shortcut iconicon" type="image/png" href="/img/favicon-32x32.png" sizes="32x32" />
<link rel="shortcut iconicon" type="image/png" href="/img/favicon-96x96.png" sizes="96x96" />
<link rel="shortcut iconicon" type="image/png" href="/img/favicon-160x160.png" sizes="160x160" />
<link rel="shortcut iconicon" type="image/png" href="/img/favicon-196x196.png" sizes="196x196" />
<meta name="msapplication-tiny70x70logo" content="/img/msapplication-tiny.png" />
<meta name="msapplication-square150x150logo" content="/img/msapplication-square.png" />
<meta name="msapplication-large310x310logo" content="/img/msapplication-large.png" />    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!--[if IE 8]><script type="text/javascript" src="/js/css3-mediaqueries.js"></script><![endif]-->
</head>
<style>
    body{min-width:300px;}
    .wrap{  position: absolute;
    min-height: 100%;
    width: 100%;
    background: #fff;
    background-size: 100% auto;
    }
    .centered{
        position:fixed;
        top:50%;
        left:50%;
        transform:translate(-50%, -50%);
    }
</style>
<body>
    <?php $this->beginBody() ?>
        <a class="logo masthead" href="/" title="Yello">Yello</a>
        <a class="link-icon font-log-in pull-right" style="top:41px;right:42px;height:60px;" href="<?= yii\helpers\Url::to('/site/logout') ?>">Sign Out</a>
        <div class="" style="margin:30px;text-align:center;">
                    <?= $content ?>
            
            </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
