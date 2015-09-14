<?php

namespace common\models\search;

use common\models\ShiftHasDriver;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Shift;
use yii\db\Query;

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
     * Search shifts completed by user, so their actualStart property is set. This variable provided for just filtering time for
     * completed shifts, as we should search in actualStart instead of start property. There is no other way to find out between
     * completed and allocated.
     *
     * @var bool
     */

    public $isCompleted;

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
            'sort'=> ['defaultOrder' => ['start'=> SORT_DESC]]
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
//           $date = new \DateTime();

            $date = date("Y-m-d H:i:s");
            $time = strtotime($date);
            $time = $time - (30 * 60);
            $startDate = date("Y-m-d H:i:s", $time);
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

        if(isset($params['text']))
        {
            $text = $params['text'];
            $query->andWhere(['IN', 'storeId', (new Query())->select('id')->from('store')->where(['isArchived' => '0'])->andWhere(['LIKE', 'title', $text])->distinct()->column()]);

        }

        if(isset($this->isCompleted))
        {

            $timeColumn = 'TIME(actualStart)';
            $dateColumn = 'DATE(actualStart)';
        }else{

            $timeColumn = 'TIME(start)';
            $dateColumn = 'DATE(start)';
        }

        if(!empty($params['fromTime']) && !empty($params['toTime'])){
            if($params['fromTime'] > $params['toTime']){
                $query->andWhere(['AND',
                    ['OR',['>=', $timeColumn, $params['fromTime']],['<=', $timeColumn,$params['toTime']] ],
                ]);
            }else{
                $query->andWhere(['>=',$timeColumn, $params['fromTime']]);
                $query->andWhere(['<=',$timeColumn, $params['toTime']]);
            }

        }elseif(!empty($params['toTime'])){

            $query->andWhere(['<=',$timeColumn, $params['toTime']]);

        }elseif(!empty($params['fromTime']) ){

            $query->andWhere(['>=',$timeColumn, $params['fromTime']]);
        }

        if(!empty($params['startDate'])){

            $startTime = date('Y-m-d', $params['startDate']);
            $query->andWhere(['>=',$dateColumn, $startTime]);
        }
        if(!empty($params['connectedstores']) && $params['connectedstores']=='1'){
            // only connected stores
            if(!empty($this->driverId)){
                $query->andWhere(['IN', 'storeId', (new Query())->select('storeId')->from('driverHasStore')->where(['isArchived' => '0','isAcceptedByDriver'=>1 ,'driverId' => $this->driverId])]);
            }

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