<?php

use yii\db\Schema;
use yii\db\Migration;

class m150617_101802_create_user_has_store_table extends Migration
{
    public function up()
    {
        $this->createTable('UserHasStore', [
            'id' => Schema::TYPE_PK,
            'userId' => Schema::TYPE_INTEGER,
            'storeId' => Schema::TYPE_INTEGER,
            'createdAt' => Schema::TYPE_INTEGER . " NOT NULL DEFAULT 0",
            'updatedAt' => Schema::TYPE_INTEGER . " NOT NULL DEFAULT 0",
            'isArchived' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
        ]);
        $this->createIndex('idx_uss_userId_storeId', 'UserHasStore', ['userId', 'storeId']);
        $this->addForeignKey('fk_userId_to_user', 'UserHasStore', 'userId', 'User', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_storeId_to_store', 'UserHasStore', 'storeId', 'Store', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('fk_storeId_to_store', 'UserHasStore');
        $this->dropForeignKey('fk_userId_to_user', 'UserHasStore');
        $this->dropIndex('idx_uss_userId_storeId', 'UserHasStore');
        $this->dropTable('UserHasStore');
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
