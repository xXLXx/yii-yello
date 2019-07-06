<?php

use yii\db\Schema;
use yii\db\Migration;

class m150603_024619_UserDriverDeleteBaseField extends Migration
{
    public function up()
    {
        $this->dropColumn('UserDriver', 'createdAt');
        $this->dropColumn('UserDriver', 'updatedAt');
        $this->dropColumn('UserDriver', 'isArchived');
    }

    public function down()
    {
        $this->addColumn(
            'UserDriver', 'createdAt', Schema::TYPE_INTEGER . ' NOT NULL'
        );
        $this->addColumn(
            'UserDriver', 'updatedAt', Schema::TYPE_INTEGER . ' NOT NULL'
        );
        $this->addColumn(
            'UserDriver', 'isArchived', Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        );
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
