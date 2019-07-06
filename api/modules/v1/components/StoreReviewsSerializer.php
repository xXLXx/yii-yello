<?php

namespace api\modules\v1\components;

use common\models\Store;

class StoreReviewsSerializer extends Serializer
{
    /**
     * Customized to include `averagesStars` into the metaenvelope
     * when request had the storeId.
     * 
     * @inheritdoc
     */
    public function serialize($data)
    {
        $result = parent::serialize($data);

        $storeId = \Yii::$app->getRequest()->get('storeId');
        if (!$storeId) {
            return $result;
        }

        $result = \yii\helpers\ArrayHelper::merge($result, [
            $this->metaEnvelope => [
                'averageStars' => Store::findOne($storeId)->getStars(),
            ]
        ]);

        return $result;
    }
}