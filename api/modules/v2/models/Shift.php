<?php
/**
 * Restful-API-v2-specific Shift model
 */

namespace api\modules\v2\models;


use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class Shift extends \api\common\models\Shift implements Linkable
{
    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(
                [
                    'shift/view',
                    'id' => $this->id,
                ],
                true
            ),
        ];
    }
}