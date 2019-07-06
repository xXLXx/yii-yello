<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Base model
 * 
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property bool $isArchived
 */
class BaseModel extends AbstractModel
{
    protected static $_namespace = __NAMESPACE__;

    /**
     * @inheritdoc
     */
    public static function find() 
    {
        return new query\BaseQuery(get_called_class());
    }

    /**
     * Get class name
     *
     * @param string $of
     * @return string
     */
    public static function getClassName($of)
    {
        return static::$_namespace . "\\" . $of;
    }
    
    /**
     * @inheritdoc
     */
    public function delete() 
    {
        $this->isArchived = true;
        $this->update();
    }

    /**
     * @param string $condition
     * @param array $params
     * @return int
     * @throws \yii\db\Exception
     */
    public static function deleteAll($condition = '', $params = [])
    {
        $command = static::getDb()->createCommand();
        $command->update(static::tableName(), ['isArchived' => 1], $condition, $params);

        return $command->execute();
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createdAt', 'updatedAt'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt'],
                ],
            ]
        ];
    }

    /**
     * Tries to find if a record exists. Else we return a new instance
     * with the condition as initial value.
     *
     * @param array $condition needs to key-value pair
     * @return static
     */
    public static function findOneOrCreate($condition)
    {
        $model = static::findOne($condition);

        if ($model) {
            return $model;
        }

        return new static($condition);
    }

    /**
     * Extended to return any error (first from the stack of errors) when no attribute is provider.
     *
     * @param string|null $attribute
     * @return mixed
     */
    public function getFirstError($attribute = null)
    {
        if (!empty($attribute)) {
            return parent::getFirstError($attribute);
        }

        $errors = $this->getFirstErrors();
        foreach ($errors as $attr => $error) {
            return array($attr => $error);
        }
    }
}
