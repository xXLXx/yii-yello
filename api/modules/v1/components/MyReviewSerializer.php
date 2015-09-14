<?php

namespace api\modules\v1\components;

use yii\db\Query;

class MyReviewSerializer extends Serializer
{
    /**
     * Customized to include `averagesStars` into the metaenvelope
     *
     * @inheritdoc
     */
    public function serialize($data)
    {
        $result = parent::serialize($data);
        $me = \Yii::$app->user->identity->id;

        $averageStars = (new Query())->from('ShiftReviews')->where(
            ['driverId'=> $me,'isArchived'=>0]
        )->average('stars');

        $result = \yii\helpers\ArrayHelper::merge($result, [
            $this->metaEnvelope => [
                'averageStars' => round($averageStars,3),
            ]
        ]);

        return $result;
    }
}