<?php

namespace frontend\widgets\Address;
use frontend\widgets\Address\assets\AddressAsset;
use yii\web\View;

/**
 * Address widget with geoloation from Google.
 */
class AddressWidget extends \yii\base\Widget
{
    public $name = 'address-widget';
    /**
     * @var \yii\base\Model
     */
    public $model;
    public $form;

    public $options = [
        'placeholder' => 'Enter your address',
        'class' => 'form-control',
    ];

    public $fieldFormatMapping = [
        'subpremise' => 'long_name',
        'street_number' => 'short_name',
        'route' => 'long_name',
        'locality' => 'long_name',
        'administrative_area_level_1' => 'short_name',
        'country' => 'long_name',
        'postal_code' => 'short_name'
    ];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->options += ['id' => $this->id];

        $this->view->registerJs('var AddressWidget = ' .json_encode([
            'id' => $this->id,
            'fieldFormatMapping' => $this->fieldFormatMapping,
            'formName' => strtolower($this->model->formName()),
        ]), View::POS_HEAD);

        AddressAsset::register($this->view);

        return $this->render('index', array('name' => $this->name, 'options' => $this->options, 'model' => $this->model, 'form' => $this->form));
    }
}
