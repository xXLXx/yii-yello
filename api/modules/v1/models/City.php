<?php
/**
 * Rest-v1-specific City model
 */

namespace api\modules\v1\models;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class City extends \api\common\models\City implements Linkable
{

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(
                [
                    'city/view',
                    'id' => $this->id,
                ],
                true
            ),
        ];
    }

}