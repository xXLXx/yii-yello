<?php

namespace frontend\widgets\Timepicker;

/**
 * Time picker widget
 *
 * @author markov
 */
class TimepickerWidget extends \yii\base\Widget
{
    public $name;
    public $value;
    public $options;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->options['id'] = isset($this->options['id']) ? 
            $this->options['id'] : 'w' . uniqid(); 
        return $this->render('default', [
            'name'    => $this->name,
            'value'   => $this->value,
            'options' => $this->options
        ]);
    }
}
