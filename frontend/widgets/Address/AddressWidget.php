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
    public $formName;
    public $options = [
        'placeholder' => 'Enter your address',
        'class' => 'form-control',
    ];

    public $fieldsMapping = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->options += ['id' => $this->id];

        $this->view->registerJs('var AddressWidget = ' .json_encode([
            'id' => $this->id,
            'fieldsMapping' => $this->fieldsMapping,
            'formName' => $this->formName
        ]), View::POS_HEAD);

        AddressAsset::register($this->view);

        return $this->render('index', array('name' => $this->name, 'options' => $this->options));
    }
}
