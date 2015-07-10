<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Role".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * 
 * @property User[] $users users
 */
class Role extends \common\models\BaseModel
{
    /**
     * SuperAdmin role name
     */
    const ROLE_SUPER_ADMIN = 'superAdmin';

    /**
     * Franchiser role name
     */
    const ROLE_FRANCHISER = 'franchiser';

    /**
     * Menu aggregator role name
     */
    const ROLE_MENU_AGGREGATOR = 'menuAggregator';

    /**
     * Driver role name
     */
    const ROLE_DRIVER = 'driver';

    /**
     * Manager role name
     */
    const ROLE_MANAGER = 'manager';

    /**
     * User role name
     */
    const ROLE_USER = 'user';

    /**
     * Store Owner role name
     */
    const ROLE_STORE_OWNER = 'storeOwner';

    /**
     * Yello Admin role name
     */
    const ROLE_YELLO_ADMIN = 'yelloAdmin';

    /**
     * Employee role name
     */
    const ROLE_EMPLOYEE = 'employee';

    /**
     * Manager created by franchiser
     */
    const ROLE_FRANCHISER_MANAGER = 'franchiserManager';

    /**
     * Manager created by franchiser with admin rights
     */
    const ROLE_FRANCHISER_MANAGER_EXTENDED = 'franchiserExtendedManager';

    /**
     * Manager created by menuAggregator
     */
    const ROLE_MA_MANAGER = 'MAManager';

    /**
     * Manager created by menuAggregator with admin rights
     */
    const ROLE_MA_MANAGER_EXTENDED = 'MAManagerExtended';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['name', 'title'], 'string', 'max' => 255]
        ];
        return array_merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }
    
    /**
     * Get users
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['roleId' => 'id']);
    }
}