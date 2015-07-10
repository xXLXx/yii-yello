<?php

use yii\db\Schema;
use yii\db\Migration;

class m150617_063953_ShiftRequestReview extends Migration
{
    public function up()
    {
        $options = null;
        if ($this->db->driverName === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        } 
        $this->createTable('ShiftRequestReview', [
            'id'    => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'text'  => Schema::TYPE_TEXT,
            'shiftId'    => Schema::TYPE_INTEGER,
            'createdAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        ], $options);
    }

    public function down()
    {
        $this->dropTable('ShiftRequestReview');
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
