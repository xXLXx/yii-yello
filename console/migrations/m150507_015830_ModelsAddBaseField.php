<?php

use yii\db\Schema;
use yii\db\Migration;

class m150507_015830_ModelsAddBaseField extends Migration
{
    public function up()
    {
        $tables = [
            'Company', 'Role', 'Driver', 'Franchiser', 'Shift', 'Store'
        ];
        foreach ($tables as $table) {
            $this->addColumn($table, 'createdAt', Schema::TYPE_INTEGER . ' NOT NULL');
            $this->addColumn($table, 'updatedAt', Schema::TYPE_INTEGER . ' NOT NULL');
            $this->addColumn($table, 'isArchived', Schema::TYPE_BOOLEAN . ' DEFAULT 0');
        }
        $this->addColumn('User', 'isArchived', Schema::TYPE_BOOLEAN . ' DEFAULT 0');
    }

    public function down()
    {
        foreach ($tables as $table) {
            $this->dropColumn($table, 'createdAt');
            $this->dropColumn($table, 'updatedAt');
            $this->dropColumn($table, 'isArchived');
        }
        $this->dropColumn('User', 'isArchived');
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
