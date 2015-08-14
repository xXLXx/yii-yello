<?php

namespace common\models\search;

use common\models\Role;
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

        $query->joinWith('role');
        $query->andWhere(
            ['Role.name' => Role::ROLE_DRIVER]
        );

        if (isset($params['searchText']) && $params['searchText']) {
            $query->andWhere([
                'OR',
                ['like', 'username', $params['searchText']],
                ['like', 'firstName', $params['searchText']],
                ['like', 'lastName', $params['searchText']],
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
            $query->joinWith('userDriver');
            $query->andFilterWhere(
                [
                    '>=',
                    'rating',
                    $params['rating'] * 20
                ]
            );
        }

        if (!empty($params['availability'])) {
            $query->joinWith('userDriver');
            $query->andFilterWhere(
                [
                    'availability' => $params['availability']
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

        if(!empty($params['storeid'])){
            
        }
        
        
        if (!empty($params['category']) && $params['category'] == 'favourites') {
            $storeOwner = \Yii::$app->user->getIdentity()->storeOwner;
            $query->joinWith('storeOwnerFavouriteDrivers');
            $query->andFilterWhere(
                [
                    'StoreOwnerFavouriteDrivers.storefk' => $storeOwner->getStoreCurrent()->id
                ]
            );
        }

        if (!empty($params['category']) && $params['category'] == 'all') {
            $storeOwner = \Yii::$app->user->getIdentity()->storeOwner;
            $query->join('LEFT OUTER JOIN', 'driverHasStore',
                'driverHasStore.driverId =user.id');     
            $query->join('LEFT OUTER JOIN', 'storeOwnerFavouriteDrivers',
                'StoreOwnerFavouriteDrivers.driverId =user.Id');     
            
            $query->andFilterWhere(['or',
                [
                    'DriverHasStore.storeId' => $storeOwner->storeCurrent->id,
                    'DriverHasStore.isAcceptedByDriver' => 1,
                    'DriverHasStore.isArchived' => 0
                ],
                [
                    'StoreOwnerFavouriteDrivers.storefk' => $storeOwner->storeCurrent->id,
                    'DriverHasStore.isArchived' => 0
                ]]
            );            
        }

        if (!empty($params['category']) && $params['category'] == 'my') {
            $storeOwner = \Yii::$app->user->getIdentity()->storeOwner;
            $query->joinWith('driverHasStore');
            $query->andFilterWhere(
                [
                    'DriverHasStore.storeId' => $storeOwner->storeCurrent->id,
                    'DriverHasStore.isAcceptedByDriver' => 1
                ]
            );
        }

        if (!empty($params['category']) && $params['category'] == 'uninvited') {
        //if (empty($params['category'])) {
            $storeOwner = \Yii::$app->user->getIdentity()->storeOwner;
            $query->join('LEFT OUTER JOIN', 'driverHasStore',
                'driverHasStore.driverId =user.id');     
            $query->join('LEFT OUTER JOIN', 'storeOwnerFavouriteDrivers',
                'StoreOwnerFavouriteDrivers.driverId =user.Id');     

            /*$query->andFilterWhere(
                [
                   [],
                //    ['!=','DriverHasStore.isAcceptedByDriver', 1]
                ]
            );
            $query->andWhere([
                '!=', 'StoreOwnerFavouriteDrivers.storeOwnerId', $storeOwner->id,
            ]);
            $query->andWhere([
                '!=', 'DriverHasStore.storeId', $storeOwner->id,
            ]);*/
        }


        return $query;
    }
    
    public function getCount($params)
    {
        $query = $this->buildQuery($params);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
        if (!$this->validate()) {
            return 0;
        }

        return $dataProvider->count;
        
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