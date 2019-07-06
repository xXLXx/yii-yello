<?php
/**
 * Rest-v1-specific VehicleType model
 */

namespace api\modules\v1\models;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class VehicleType extends \api\common\models\VehicleType implements Linkable
{

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(
                [
                    'vehicle-type/view',
                    'id' => $this->id,
                ],
                true
            ),
        ];
    }

}