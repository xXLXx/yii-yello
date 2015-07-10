<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Driver;

/**
 * DriverSearch represents the model behind the search form about `common\models\Driver`.
 */
class DriverSearch extends Driver
{

    /**
     * Availability
     *
     * @var integer|null
     */
    public $availability;

    /**
     * Model to search on
     *
     * @var string
     */
    public $modelClass = "common\\models\\Driver";

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'availability'
                ],
                'string'
            ],
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
     * @return \yii\db\ActiveQuery
     */
    public function buildQuery($params)
    {
        $this->load($params);
        $query = static::find();
        $query->with(['image']);
        if (isset($params['searchText'])) {
            $query->andWhere([
                'OR',
                ['like', 'username', $params['searchText']],
                ['like', 'email', $params['searchText']],
                ['User.id' => $params['searchText']],
            ]);
        }
        if (!empty($params['name'])) {
            $query->andFilterWhere(
                [
                    'like',
                    'username',
                    $params['name']
                ]
            );
        }

        if (!empty($params['rating'])) {
            $query->andFilterWhere(
                [
                    '>=',
                    'rating',
                    $params['rating'] * 20
                ]
            );
        }

        if (!empty($params['availability'])) {
            $query->andFilterWhere(
                [
                    'like',
                    'availability',
                    $params['availability']
                ]
            );
        }

        if (!empty($params['vehicle'])) {
            $query->joinWith('vehicleTypes');
            $query->andFilterWhere(
                [
                    'VehicleType.name' => $params['vehicle']
                ]
            );
        }

        if (!empty($params['category']) && $params['category'] == 'favourites') {
            $storeOwner = \Yii::$app->user->getIdentity()->storeOwner;
            $query->joinWith('storeOwnerFavouriteDrivers');
            $query->andFilterWhere(
                [
                    'StoreOwnerFavouriteDrivers.storeOwnerId' => $storeOwner->id
                ]
            );
        }

        if (!empty($params['category']) && $params['category'] == 'my') {
            $storeOwner = \Yii::$app->user->getIdentity()->storeOwner;
            $query->joinWith('driverHasStore');
            $query->andFilterWhere(
                [
                    'DriverHasStore.storeId' => $storeOwner->getStoreCurrent()->id,
                    'DriverHasStore.isAcceptedByDriver' => 1
                ]
            );
        }
        return $query;
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
        $query = $this->buildQuery($params);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}