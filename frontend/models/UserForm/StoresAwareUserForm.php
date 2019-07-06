<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 17.06.2015
 * Time: 13:44
 */

namespace frontend\models\UserForm;
use app\models\UserForm\StoresAwareTrait;
use common\models\Role;
use common\models\Store;
use common\models\StoreOwner;
use common\models\User;
use Yii;

/**
 * Class StoresAwareUserForm
 * @package frontend\models\UserForm
 */
class StoresAwareUserForm extends CommonManagerForm
{
    use StoresAwareTrait;

    public $isBlocked;

    
    
    /**
     * Check rules
     * @return array
     */
    public function rules()
    {
        return array_merge([
            [['firstName', 'lastName', 'email', 'roleId', 'stores' ], 'safe'],
            [['isBlocked','isAdmin'], 'boolean']
        ], parent::rules());
    }

    /**
     * Save model
     */
    public function save()
    {
        /** @var User $user */
        $user = User::findOne($this->id);
        if ($user) {
            $this->saveUserStoreRelations($user);
            $user->isBlocked = $this->isBlocked;
//            if(\Yii::$app->user->can('AssignUserToStore')){
//                $this->setIsAdminDependentRole($user);
//            }
            $user->save();
        }
        parent::save();
    }


}