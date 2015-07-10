<?php

use common\models\Role;
use yii\db\Migration;

class m150624_114923_add_new_fr_ma_manager_roles extends Migration
{

    public function up()
    {
        $this->insert(Role::tableName(), [
            'name' => Role::ROLE_FRANCHISER_MANAGER,
            'title' => 'Manager'
        ]);
        $this->insert(Role::tableName(), [
            'name' => Role::ROLE_FRANCHISER_MANAGER_EXTENDED,
            'title' => 'Manager'
        ]);
        $this->insert(Role::tableName(), [
            'name' => Role::ROLE_MA_MANAGER,
            'title' => 'Manager'
        ]);
        $this->insert(Role::tableName(), [
            'name' => Role::ROLE_MA_MANAGER_EXTENDED,
            'title' => 'Manager'
        ]);
    }

    public function down()
    {
        $this->delete(Role::tableName(), [
            'name' => [
                Role::ROLE_MA_MANAGER,
                Role::ROLE_MA_MANAGER_EXTENDED,
                Role::ROLE_FRANCHISER_MANAGER,
                Role::ROLE_FRANCHISER_MANAGER_EXTENDED
            ]
        ]);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
