<?php

use yii\db\Schema;
use yii\db\Migration;

class m150514_023804_TimeFormat extends Migration
{
    public function up()
    {
        $options = [];
        if ($this->db->driverName === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('TimeFormat', [
            'id'    => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'name'  => Schema::TYPE_STRING,
            'createdAt'     => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt'     => Schema::TYPE_INTEGER . ' NOT NULL',
            'isArchived'    => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        ], $options);
    }

    public function down()
    {
        $this->dropTable('TimeFormat');
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
