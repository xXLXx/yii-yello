<?php
/**
 * Rest-v1-specific Driver model
 */

namespace api\modules\v1\models;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class Driver extends \api\common\models\Driver implements Linkable
{

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(
                [
                    'driver/view',
                    'id' => $this->id,
                ],
                true
            ),
        ];
    }

}