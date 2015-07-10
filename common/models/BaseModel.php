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
}
