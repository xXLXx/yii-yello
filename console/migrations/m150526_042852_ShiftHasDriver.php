<?php

use yii\db\Schema;
use yii\db\Migration;

class m150526_042852_ShiftHasDriver extends Migration
{
    public function up()
    {
        $options = null;
        if ($this->db->driverName === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('ShiftHasDriver', [
            'id'         => Schema::TYPE_PK,
            'shiftId'    => Schema::TYPE_INTEGER,
            'userId'     => Schema::TYPE_INTEGER,
            'createdAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        ], $options);
    }

    public function down()
    {
        $this->dropTable('ShiftHasDriver');
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
