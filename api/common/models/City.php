<?php
/**
 * Rest model for City
 */

namespace api\common\models;


class City extends \common\models\City
{
    public function fields()
    {
        $parentfields = parent::fields();
        $fields = [
            'id',
            'name',
            'title',
            'stateId',
            'createdAt',
            'updatedAt'
        ];
        $fields = array_merge($parentfields, $fields);
        return $fields;
    }
}