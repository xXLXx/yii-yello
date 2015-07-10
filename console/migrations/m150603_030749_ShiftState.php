<?php

use yii\db\Schema;
use yii\db\Migration;

class m150603_030749_ShiftState extends Migration
{
    public function up()
    {
        $options = null;
        if ($this->db->driverName === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }   
        $this->createTable('ShiftState', [
            'id'    => Schema::TYPE_PK,
            'name'  => Schema::TYPE_STRING,
            'title' => Schema::TYPE_STRING,
            'sort'  => Schema::TYPE_INTEGER . ' DEFAULT 0',
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        ], $options);
    }

    public function down()
    {
        $this->dropTable('ShiftState');
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
