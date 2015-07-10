<?php

namespace frontend\widgets\Dashboard;

use \yii\base\Widget;

/**
 * Class DonutChartWidget
 * @package frontend\widgets\DonutChartWidget
 *
 * @author alex
 */
class DonutChartWidget extends Widget
{

    public $title;

    public $count;

    public $items;

    public function run()
    {
        return $this->render('donutChart',
            [
                'title' => $this->title,
                'count' => $this->count,
                'items' => $this->items
            ]
        );
    }

}