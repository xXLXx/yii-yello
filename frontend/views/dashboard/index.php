<?php
    use frontend\widgets\Dashboard\DonutChartWidget;
    use frontend\widgets\Dashboard\LineChartWidget;
    use yii\web\View;
    use yii\jui\DatePicker;

    $this->registerJs('
        function OnEndDateChange (value) {
            var regex = /(.+enddate=)\d{4}-\d{2}-\d{2}(.+)?/;
            if (!window.location.href.match(regex)) {
                window.location.href = window.location.href.replace(/\?/, "?enddate=" + value + "&");
            } else {
                window.location.href = window.location.href.replace(regex, "$1" + value + "$2");
            }
        }
    ', View::POS_BEGIN);
?>
<div class="content clearfix">
    <div class="top-filter">
        <div class="period-list clearfix">
            <?php foreach (['today', 'yesterday', 'week', 'month', 'quarter', 'year'] as $value) : ?>
                <a class="item <?= $range == $value ? 'active' : '' ?>" href="?range=<?= $value ?>&enddate=<?= $enddate ?>"><?= ucfirst($value) ?></a>
            <?php endforeach; ?>
        </div>
        <div class="datepicker-wrapp">
            <label for="period">End Date</label>
            <?=
                DatePicker::widget([
                    'attribute'     => 'date',
                    'dateFormat'    => 'yyyy-MM-dd',
                    'value'         => $enddate,
                    'options'       => [
                        'class'         => 'text-input small',
                        'onchange'      => 'OnEndDateChange(this.value)'
                    ]
                ]);
            ?>
        </div>
    </div>
    <div class="dashboard-two-cols-container">
        <div class="dashboard-fisrt-column">
            <div class="diagram-list">
                <?= DonutChartWidget::widget([
                    'title' => 'Shifts',
                    'count' => $shiftCount,
                    'items' => $shiftItems
                ])?>
                <?= DonutChartWidget::widget([
                    'title' => 'Drivers',
                    'count' => $driverCount,
                    'items' => $driverItems
                ])?>
<!--                <div class="diagram-item clearfix">-->
<!--                    <div class="f-right">-->
<!--                        <img src="img/temp/09.png" />-->
<!--                    </div>-->
<!--                    <div class="f-left">-->
<!--                        <h3>Shifts</h3>-->
<!--                        <h2>147</h2>-->
<!--                        <ul class="color-list">-->
<!--                            <li class="red">Pending (4)</li>-->
<!--                            <li class="green">Completed (25)</li>-->
<!--                            <li class="yellow">Allocated Yello (0)</li>-->
<!--                            <li>Allocated (25)</li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="diagram-item clearfix">-->
<!--                    <div class="f-right">-->
<!--                        <img src="img/temp/10.png" />-->
<!--                    </div>-->
<!--                    <div class="f-left">-->
<!--                        <h3>Drivers</h3>-->
<!--                        <h2>343</h2>-->
<!--                        <ul class="color-list">-->
<!--                            <li class="blue">Favorite Drivers (2)</li>-->
<!--                            <li class="yellow">Yello Drivers (8)</li>-->
<!--                            <li>Store drivers (25)</li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
        <div class="dashboard-second-column">
            <table class="border-all-list">
                <tr class="time-line">
                    <td class="time-item empty"></td>
                    <td>
                        <table class="line-header <?= $range ?>">
                            <tr>
                                <?php foreach ($timeline as $item) if (isset($item['label'])) : ?>
                                <td class="time-item"><span><?= $item['label'] ?></span></td>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="border-all-item">
                    <td class="f-left">
                        <h3>Paid</h3>
                        <h2><?= $paid ?></h2>
                        <h4>Avg. <?= $paidAverage?>/day</h4>
                    </td>
                    <td class="f-right">
                        <?= LineChartWidget::widget(array(
                            'data' => $paidData,
                            'color' => '#BDD071',
                            'scriptAfterArrayToDataTable' => '
                                var formatter = new google.visualization.NumberFormat({prefix: "$"});
                                formatter.format(data, 1);'
                        )); ?>
                    </td>
                </tr>
                <tr class="border-all-item">
                    <td class="f-left">
                        <h3>Applications</h3>
                        <h2><?= $applications ?></h2>
                    </td>
                    <td class="f-right">
                        <?= LineChartWidget::widget(array(
                            'data' => $applicationsData,
                            'color' => '#3BAFDA'
                        )); ?>
                    </td>
                </tr>
                <tr class="border-all-item">
                    <td class="f-left">
                        <h3>Deliveries</h3>
                        <h2><?= $deliveries ?></h2>
                        <h4>Avg. <?= $deliveriesAverage ?>/day</h4>
                    </td>
                    <td class="f-right">
                        <?= LineChartWidget::widget(array(
                            'data' => $deliveriesData,
                            'color' => '#F5AA2E'
                        )); ?>
                    </td>
                </tr>
                <tr class="border-all-item">
                    <td class="f-left">
                        <h3>Shifts Booked</h3>
                        <h2><?= $shiftsBooked ?></h2>
                        <h4>Avg. <?= $shiftsBookedAverage ?>/day</h4>
                    </td>
                    <td class="f-right">
                        <?= LineChartWidget::widget(array(
                            'data' => $shiftsBookedData,
                            'color' => '#5396E3'
                        )); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>