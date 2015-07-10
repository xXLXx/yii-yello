<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DriverHasStore;

/**
 * DriverHasStoreSearch represents the model behind the search form about `common\models\DriverHasStore`.
 */
class DriverHasStoreSearch extends DriverHasStore
{
    /**
     * Class name of the Model to search
     *
     * @var DriverHasStore|string
     */
    public static $modelClass = 'common\models\DriverHasStore';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'driverId',
                    'storeId',
                    'createdAt',
                    'updatedAt',
                    'isArchived'
                ],
                'integer'
            ],
            [
                [
                    'isInvitedByStoreOwner',
                    'isAcceptedByDriver',
                ],
                'boolean',
            ],
            [
                [
                    'isInvitedByStoreOwner',
                    'isAcceptedByDriver',
                ],
                'default',
                'value' => null,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $modelClass = static::$modelClass;
        $query = $modelClass::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if (!is_null($this->isAcceptedByDriver)) {
            $query->andWhere([
                'isAcceptedByDriver' => $this->isAcceptedByDriver,
            ]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'driverId' => $this->driverId,
            'storeId' => $this->storeId,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'isInvitedByStoreOwner' => $this->isInvitedByStoreOwner,
            'isAcceptedByDriver' => $this->isAcceptedByDriver,
            'isArchived' => $this->isArchived,
        ]);

        return $dataProvider;
    }
}