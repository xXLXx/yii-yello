<?php
/**
 * Rest-v1-specific Image model
 */

namespace api\modules\v1\models;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class Image extends \api\common\models\Image implements Linkable
{
    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(
                [
                    'image/view',
                    'id' => $this->id,
                ],
                true
            ),
        ];
    }

    public function fields()
    {
        return [
            'id',
            'originalUrl',
            'largeUrl',
            'thumbUrl',
            'title',
            'alt'
        ];
    }
}