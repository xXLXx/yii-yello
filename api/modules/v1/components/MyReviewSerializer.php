<?php

namespace api\modules\v1\components;

class MyReviewSerializer extends Serializer
{
    /**
     * Customized to include `averagesStars` into the metaenvelope
     * This is like StoreReviewsSerializer as both items has 'star' property, but we do not need storeId here.
     * Maybe if the checking for StoreId is not necessary for StoreReviewsSerializer, we can remove this class and use that one
     * for serializing both MyReviews and StoreReviews. Because they are doing the exact same job.
     *
     * @inheritdoc
     */
    public function serialize($data)
    {
        $result = parent::serialize($data);

        $averageStars = 0;
        if (count($result[$this->collectionEnvelope]) > 0) {
            $_totalStars = 0;
            foreach ($result[$this->collectionEnvelope] as $item) {
                if(isset($item['stars'])){
                    $_totalStars += (float)$item['stars'];
                }
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