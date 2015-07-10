<?php
    use frontend\widgets\Dashboard\DonutChartWidget;
?>
<div class="content clearfix">
    <div class="top-filter">
        <div class="period-list clearfix">
            <div class="item">Today</div>
            <div class="item">Yesterday</div>
            <div class="item active">Week</div>
            <div class="item">Month</div>
            <div class="item">Quarter</div>
            <div class="item">Year</div>
        </div>
        <div class="datepicker-wrapp">
            <label for="period">Period</label>
            <input id="period" type="text" class="text-input small" value="17 Aprill, 2015" />
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
            <div class="border-all-list">
                <div class="time-line">
                    <div class="time-item empty"></div>
                    <div class="time-item"><span>01.03.15</span></div>
                    <div class="time-item"><span>02.03.15</span></div>
                    <div class="time-item"><span>03.03.15</span></div>
                    <div class="time-item"><span>04.03.15</span></div>
                    <div class="time-item"><span>05.03.15</span></div>
                    <div class="time-item"><span>06.03.15</span></div>
                    <div class="time-item"><span>07.03.15</span></div>
                </div>
                <div class="border-all-item clearfix">
                    <div class="f-left">
                        <h3>Paid</h3>
                        <h2>$1,233</h2>
                        <h4>Avg. $213/day</h4>
                    </div>
                    <div class="f-right">
                        <img src="img/temp/11.png" />
                    </div>
                </div>
                <div class="border-all-item clearfix">
                    <div class="f-left">
                        <h3>Applications</h3>
                        <h2>1183</h2>
                    </div>
                    <div class="f-right">
                        <img src="img/temp/12.png" />
                    </div>
                </div>
                <div class="border-all-item clearfix">
                    <div class="f-left">
                        <h3>Deliveries</h3>
                        <h2>4383</h2>
                        <h4>Avg. 813/day</h4>
                    </div>
                    <div class="f-right">
                        <img src="img/temp/13.png" />
                    </div>
                </div>
                <div class="border-all-item clearfix">
                    <div class="f-left">
                        <h3>Shifts Booked</h3>
                        <h2>3383</h2>
                        <h4>Avg. 813/day</h4>
                    </div>
                    <div class="f-right">
                        <img src="img/temp/14.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>