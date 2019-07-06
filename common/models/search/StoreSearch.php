<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 25.06.2015
 * Time: 17:39
 */

namespace common\models\search;


use common\models\Store;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class StoreSearch extends Store
{

    /**
     * Model to search on
     *
     * @var string
     */
    public $modelClass = "common\\models\\Store";

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
//            $query->andWhere(strtr("CONCAT(title, contactPerson) LIKE '%:query%'", [
//                ':query' => $params['query']
//            ]));
            $query->andFilterWhere(['like', 'title', $params['query']]);
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