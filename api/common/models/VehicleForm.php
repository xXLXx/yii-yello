<?php
/**
 * Rest model for VehicleForm
 */

namespace api\common\models;


class VehicleForm extends \frontend\models\VehicleForm
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
