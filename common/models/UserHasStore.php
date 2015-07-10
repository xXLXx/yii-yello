<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 17.06.2015
 * Time: 14:20
 */

namespace common\models;


/**
 * Class UserHasStore - relation-model for managers/employees and stores
 *
 * @property int id
 * @property int storeId
 * @property int userId
 *
 * @package common\models
 */
class UserHasStore extends BaseModel
{
    public static function tableName()
    {
        return 'UserHasStore';
    }

    public function rules()
    {
        return parent::rules();
    }

    public function attributeLabels()
    {
        return parent::attributeLabels();
    }
}