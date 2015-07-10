<?php

namespace api\common\models;

/**
 * Class DriverHasStore
 *
 * Restful DriverHasStore model
 *
 * @package api\common\models
 */

class DriverHasStore extends \common\models\DriverHasStore
{
    protected static $_namespace = __NAMESPACE__;

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['driver', 'store'];
    }
}