<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_023929_Activity extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('Activity', [
            'id'         => Schema::TYPE_PK,
            'name'       => Schema::TYPE_STRING,
            'userId'     => Schema::TYPE_INTEGER,
            'createdAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        ], $tableOptions);
        $this->addForeignKey('user_userId', 'Activity', 'userId', 'User', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('user_userId', 'Activity');
        $this->dropTable('Activity');
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
