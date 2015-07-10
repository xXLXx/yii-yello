<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\widgets\TopNavigation;

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
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">google.load("visualization", "1", {packages: ["corechart"]});</script>
<!--    <script type="text/javascript">-->
<!--    google.load("visualization", "1", {packages: ["corechart"]});-->
<!--    google.setOnLoadCallback(drawChart);-->
<!--    function drawChart() {-->
<!--        var data = google.visualization.arrayToDataTable([-->
<!--            ['Task', 'Hours per Day'],-->
<!--            ['Work', 11],-->
<!--            ['Eat', 2],-->
<!--            ['Commute', 2],-->
<!--            ['Watch TV', 2],-->
<!--            ['Sleep', 7]-->
<!--        ]);-->
<!--        var options = {-->
<!--            title: 'My Daily Activities',-->
<!--            pieHole: 0.4,-->
<!--        };-->
<!--        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));-->
<!--        chart.draw(data, options);-->
<!--    }-->
<!--    </script>-->
</head>
<body>
    <?php $this->beginBody() ?>
        <div class="wrapper j_fix_header">
            <?= TopNavigation::widget(); ?>
            <div class="content clearfix">
                <?= $content ?>
            </div>
        </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
