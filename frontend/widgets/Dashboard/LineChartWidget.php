<?php

namespace frontend\widgets\Dashboard;

use scotthuangzl\googlechart\GoogleChart;
use yii\web\View;

/**
 * Class LineChartWidget
 * @package frontend\widgets\LineChartWidget
 *
 * @author -xXLXx-
 */
class LineChartWidget extends GoogleChart
{

    public $data;

    public $visualization = 'LineChart';

    public $options = array(
        'titleTextStyle' => array('color' => '#FF0000'),
        'vAxis' => array(
            'gridlines' => array(
                'color' => '#EDEDED',
                'count' => 3
            ),
            'baselineColor' => 'none',
        ),
        'hAxis' => array(
            'textPosition'  => 'none',
            'gridlines' => array(
                'color' => 'none',
            ),
            'baseline'  => 0,
            'baselineColor' => '#ABACAE'
        ),
        'legend' => array(
            'position' => 'none'
        ),
        'height' => 100,
        'lineWidth' => 1,
        'chartArea' => array(
            'width' => '85%',
            'left'  => '10%'
        )
    );

    public $color = '#FAD00A';

    public function run()
    {
        $id = $this->getId();
        if (isset($this->options['id']) and !empty($this->options['id'])) $id = $this->options['id'];

        $view = $this->getView();
        $view->registerCss('#div-chart' . $id . ' [fill="#abacae"] { width: 2.3px }', array(), $id);
        $this->options['hAxis']['baseline'] = $this->data[1][0];
        $this->options['colors'] = array($this->color);
        return parent::run();
    }

}