<?php

use yii\db\Schema;
use yii\db\Migration;

class m150513_014258_AddRole extends Migration
{
    public function up()
    {
        $this->insert('Role', [
            'name'  => 'yelloAdmin',
            'title' => 'Yello Admin'
        ]);
    }

    public function down()
    {
        $this->delete('Role', ['name' => 'yelloAdmin']);
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
