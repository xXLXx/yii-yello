<?php

namespace api\modules\v1\models\search;

/**
 * Class DriverHasStoreSearch
 *
 * v1-specific Restful DriverHasStoreSearch model
 *
 * @package api\modules\v1\models\search
 */

class DriverHasStoreSearch extends \common\models\search\DriverHasStoreSearch
{
    /**
     * @inheritdoc
     */
    public static $modelClass = 'api\modules\v1\models\DriverHasStore';
}