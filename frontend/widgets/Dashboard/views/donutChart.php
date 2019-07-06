<?php
    use frontend\widgets\Dashboard\assets\DonutChartAsset;
    DonutChartAsset::register($this);
?>
<div class="diagram-item clearfix">
    <div class="f-right">
<!--        <img src="img/temp/10.png" />-->
        <div id="donutchart<?= $title ?>"></div>
    </div>
    <div class="f-left">
        <h3><?= $title ?></h3>
        <h2><?= $count ?></h2>
        <ul class="color-list">
            <?php foreach($items as $item): ?>
                <li
                    <?php if (isset($item['class'])):?>
                        class="<?= $item['class'] ?>"
                    <?php endif ?>
                >
                <?= $item['title'] ?> (<?= $item['count'] ?>)</li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
<?php $items = json_encode($items)?>
<?= $this->registerJs("DonutChart.draw('$title', $items);"); ?>