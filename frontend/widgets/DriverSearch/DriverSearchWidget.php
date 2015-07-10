<?php

namespace frontend\widgets\DriverSearch;

use yii\helpers\Url;
use yii\helpers\Json;

/**
 * Driver search widget
 *
 * @author markov
 */
class DriverSearchWidget extends \yii\base\Widget
{
    /**
     * Form
     * 
     * @var \yii\base\Model
     */
    public $model;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $formName = $this->model->formName();
        $paramsJson = Json::encode([
            'sourceAutocompleteUrl' => 
                Url::to(['driver-search-autocomplete/autocomplete']),
            'sourceSelectedUrl' => 
                Url::to(['driver-search-autocomplete/selected']),
            'formName'   => $formName
        ]);
        return $this->render('default', [
            'paramsJson' => $paramsJson,
            'formName'   => $formName,
            'model'      => $this->model
        ]);
    }
}
