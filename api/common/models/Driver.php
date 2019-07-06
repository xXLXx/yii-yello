<?php
/**
 * Rest model for Driver
 */

namespace api\common\models;


class Driver extends \common\models\Driver
{
    public function fields()
    {
        $parentfields = parent::fields();
        $fields = [
            'id',
            'username',
            'email',
            'active',
            'firstName',
            'lastName',
            'imageId',
        ];
        $fields = array_merge($parentfields, $fields);
        $fields['vehicle'] = function(Driver $model) {
            return $model->vehicle;
        };
        return $fields;
    }
}