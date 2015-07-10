<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShiftState;
use yii\db\Expression;

/**
 * ShiftStateSearch represents the model behind the search form about `\common\models\ShiftState`.
 */
class ShiftStateSearch extends ShiftState
{
    /**
     * Whether to include store counts into the search field list
     *
     * @var bool
     */
    public $includeStoreCount = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'sort',
                    'createdAt',
                    'updatedAt',
                    'isArchived'
                ],
                'integer'
            ],
            [
                [
                    'name',
                    'title',
                    'color'
                ],
                'safe'
            ],
            [
                [
                    'includeStoreCount',
                ],
                'boolean',
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
        $query = ShiftState::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sort' => $this->sort,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'isArchived' => $this->isArchived,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'color', $this->color]);

        if ($this->includeStoreCount) {
            $query
                ->joinWith('shifts')
                ->groupBy([
                    'Shift.id',
                ])
                ->select(//'ShiftState.id, count(Shift.id) AS shiftCount'
                    [
                    'ShiftState.id',
//                    'count' => new Expression("count(Shift.id)"),
                    'shiftCount' => 'count(Shift.id)',
                    ]
                )
            ;
        }

        return $dataProvider;
    }
}