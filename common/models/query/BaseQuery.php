<?php

namespace common\models\query;
use yii\db\ActiveRecord;

/**
 * Base query
 * 
 * @author markov
 */
class BaseQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     */
    public function init() 
    {
        parent::init();
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        $this->andWhere([$tableName . '.isArchived' => 0]);
    }
}