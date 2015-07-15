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

<link rel="shortcut icon" href=“/favicon.ico" type="image/x-icon" />
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

<script language="javascript" type="text/javascript">

    function popdatetime() {
        var d = new Date(),
            minutes = d.getMinutes().toString().length == 1 ? '0' + d.getMinutes() : d.getMinutes(),
            hours = d.getHours().toString().length == 1 ? '' + d.getHours() : d.getHours(),
            ampm = d.getHours() >= 12 ? 'PM' : 'AM',
            seconds = d.getSeconds(),
            months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        var datedisp = months[d.getMonth()] + ' ' + d.getDate() + ' ' + d.getFullYear();
        var timedisp = hours + ' ' + minutes + ' ' + ampm;
        console.log(timedisp);
        $("#todaysdate").html(datedisp);
        $("#todaystime").html(timedisp);
    }

    jQuery(document).ready(function(){
        
        setInterval(popdatetime,15000);
        
    });


</script>

</html>
<?php $this->endPage() ?>
