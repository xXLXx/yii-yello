<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 26.06.2015
 * Time: 13:57
 */

namespace common\models\search;


use common\models\Invitation;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class InvitationSearch extends Invitation
{
    /**
     * Model to search on
     *
     * @var string
     */
    public $modelClass = "common\\models\\Invitation";

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @return ActiveQuery
     */
    public function buildQuery($params)
    {
        $this->load($params);
        $query = static::find();
        if (!empty($params['query'])) {
            $query->andFilterWhere(['like', 'name', $params['query']]);
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