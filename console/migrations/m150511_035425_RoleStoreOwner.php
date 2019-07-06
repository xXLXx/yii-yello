<?php

use yii\db\Schema;
use yii\db\Migration;

class m150511_035425_RoleStoreOwner extends Migration
{
    public function up()
    {
        $this->insert('Role', [
            'title' => 'Store Owner',
            'name' => 'storeOwner'
        ]);
    }

    public function down()
    {
        $this->delete('Role', ['name' => 'storeOwner']);
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
