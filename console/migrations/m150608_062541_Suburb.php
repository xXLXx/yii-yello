<?php

use yii\db\Schema;
use yii\db\Migration;

class m150608_062541_Suburb extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $options = null;
        if ($this->db->driverName === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        } 
        $this->createTable('Suburb', [
            'id'    => Schema::TYPE_PK,
            'name'  => Schema::TYPE_STRING,
            'title' => Schema::TYPE_STRING,
            'cityId' => Schema::TYPE_INTEGER . ' DEFAULT 0',
            'createdAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        ], $options);
    }
    
    public function safeDown()
    {
        $this->dropTable('Suburb');
    }
    
}
