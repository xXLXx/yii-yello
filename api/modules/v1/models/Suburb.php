<?php
/**
 * Rest-v1-specific City model
 */

namespace api\modules\v1\models;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class Suburb extends \api\common\models\Suburb implements Linkable
{

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(
                [
                    'suburb/view',
                    'id' => $this->id,
                ],
                true
            ),
        ];
    }

}