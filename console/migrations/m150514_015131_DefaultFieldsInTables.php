<?php

use yii\db\Schema;
use yii\db\Migration;

class m150514_015131_DefaultFieldsInTables extends Migration
{
    public function up()
    {
        $tables = [
            'Country', 'Currency', 'State', 'StoreOwner', 'SuperAdmin', 
            'TimeZone'
        ];
        foreach ($tables as $table) {
            $this->addColumn($table, 'createdAt', Schema::TYPE_INTEGER . ' NOT NULL');
            $this->addColumn($table, 'updatedAt', Schema::TYPE_INTEGER . ' NOT NULL');
            $this->addColumn($table, 'isArchived', Schema::TYPE_BOOLEAN . ' DEFAULT 0');
        }
    }

    public function down()
    {
        $tables = [
            'Country', 'Currency', 'State', 'StoreOwner', 'SuperAdmin', 
            'TimeZone'
        ];
        foreach ($tables as $table) {
            $this->dropColumn($table, 'createdAt');
            $this->dropColumn($table, 'updatedAt');
            $this->dropColumn($table, 'isArchived');
        }
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
