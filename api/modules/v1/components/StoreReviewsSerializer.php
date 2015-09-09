<?php

namespace api\modules\v1\components;

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

        if (!\Yii::$app->getRequest()->get('storeId')) {
            return $result;
        }

        $averageStars = 0;
        if (count($result[$this->collectionEnvelope]) > 0) {
            $_totalStars = 0;
            foreach ($result[$this->collectionEnvelope] as $item) {
                $_totalStars += (float)$item['stars'];
            }
            $averageStars = $_totalStars / count($result[$this->collectionEnvelope]);
        }

        $result = \yii\helpers\ArrayHelper::merge($result, [
            $this->metaEnvelope => [
                'averageStars' => $averageStars,
            ]
        ]);

        return $result;
    }
}