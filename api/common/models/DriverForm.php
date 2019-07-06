<?php
/**
 * Rest model for DriverForm
 */

namespace api\common\models;


class DriverForm extends \frontend\models\UserForm\DriverForm
{
    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        $this->setAttributes($data);
        return true;
    }
}
