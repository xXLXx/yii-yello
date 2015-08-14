<?php

namespace common\models\search;

use common\models\ShiftHasDriver;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Shift;

/**
 * ShiftSearch represents the model behind the search form about `common\models\Shift`.
 */
class ShiftSearch extends Shift
{
    /**
     * Search shifts assigned by StoreOwner to at least one driver
     *
     * @var bool
     */
    public $acceptedByStoreOwner;
    /**
     * Search shifts after this moment
     *
     * @var bool
     */
    public $startsAfterNow;

    /**
     * Search shifts applied by $driverId driver to
     *
     * @var bool
     */
    public $appliedByDriver;

    /**
     * Search shifts with declined by Store Owner driver applications
     *
     * @var bool
     */
    public $declinedByStoreOwner;

    /**
     * Driver which to search shifts for
     *
     * @var integer|null
     */
    public $driverId;

    /**
     * Models to join with
     *
     * @var array
     */
    public $joinWith = [];

    /**
     * Model to search on
     *
     * @var string
     */
    public $modelClass = "common\\models\\Shift";

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'isVehicleProvided',
                    'isYelloDrivers',
                    'isMyDrivers',
                    'createdAt',
                    'updatedAt',
                    'isArchived',
                    'storeId',
                    'driverId',
                    'deliveryCount',
                    'payment',
                ],
                'integer'
            ],
            [
                [
                    'start',
                    'end',
                    'approvedApplicationId',
                    'shiftStateId',
                ],
                'safe'
            ],
            [
                [
                    'acceptedByStoreOwner',
                    'declinedByStoreOwner',
                ],
                'boolean',
            ],
            [
                [
                    'declinedByStoreOwner',
                ],
                'default',
                'value' => false,
            ],
            [
                [
                    'actualStart',
                    'actualEnd',
                ],
                'safe',
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /** @var Shift $model */
        $model = $this->modelClass;
        $query = $model::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['start'=>SORT_ASC]]            
        ]);
        $dataProvider->sort->attributes['start'] = [
              // The tables are the ones our relation are configured to
              // in my case they are prefixed with "tbl_"
              'asc' => ['start' => SORT_ASC],
              'desc' => ['start' => SORT_DESC],
          ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // return $dataProvider;
        }
        
        // omit failed applications
        if (isset($this->declinedByStoreOwner) && !is_null($this->declinedByStoreOwner)) {
            $shiftIds = ShiftHasDriver::find()
                ->andWhere([
                    'isDeclinedByStoreOwner' => true,
                ])
                ->select('shiftId')
                ->distinct()
                ->column()
                ;
            $query->andWhere([
                ($this->declinedByStoreOwner ? 'in' : 'not in'), 'Shift.id', $shiftIds
            ]);
        }

        if (isset($this->acceptedByStoreOwner) || isset($this->driverId)) {
            $driverLinks = ShiftHasDriver::find();
            if (isset($this->acceptedByStoreOwner)) {
                $driverLinks->andWhere([
                    'acceptedByStoreOwner' => $this->acceptedByStoreOwner,
                ]);
            }
            if (isset($this->driverId)) {
                $driverLinks->andOnCondition([
                    'driverId' => $this->driverId,
                ]);
            }

            $shiftIds = $driverLinks
                ->select('shiftId')
                ->distinct()
                ->column()
                ;
//            echo $this->acceptedByStoreOwner;
//            print_r($shiftIds);
            if (!empty($this->driverId) && isset($this->appliedByDriver) && $this->appliedByDriver === false) {
                $query->andWhere([
                    'not in', 'Shift.id', $shiftIds
                ]);
            } else {
                $query->andWhere(['Shift.id' => $shiftIds,]);
            }
        }




        if (isset($this->startsAfterNow)) {
           $date = new \DateTime();
             $startDate = $date->format('Y-m-d H:i:s');
            $query->andWhere([
                '>','start',$startDate
            ]);
       }
       
       
       
        if ($this->shiftStateId) {
            $query->andWhere([
                'shiftStateId' => $this->shiftStateId,
            ]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'start' => $this->start,
            'end' => $this->end,
            'isVehicleProvided' => $this->isVehicleProvided,
            'isYelloDrivers' => $this->isYelloDrivers,
            'isMyDrivers' => $this->isMyDrivers,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'isArchived' => $this->isArchived,
//            'storeId' => $this->storeId,
        ]);

        if ($this->storeId) {
            $query->andWhere([
                'storeId' => $this->storeId,
            ]);
        }

        $query->andFilterWhere(['like', 'approvedApplicationId', $this->approvedApplicationId]);

        $joins = $this->joinWith;
        if (!empty($joins) && is_array($joins) && count($joins)) {
            foreach ($joins as $table) {
                $query->joinWith($table);
            }
        }

        return $dataProvider;
    }
}