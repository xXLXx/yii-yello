<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_024030_ActivityParam extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('ActivityParam', [
            'id' => Schema::TYPE_PK,
            'field' => Schema::TYPE_STRING,
            'value' => Schema::TYPE_TEXT,
            'activityId' => Schema::TYPE_INTEGER,
            'createdAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        ], $tableOptions);
        $this->addForeignKey(
            'activity_activityId', 
            'ActivityParam', 
            'activityId', 
            'Activity', 
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('activity_activityId', 'ActivityParam');
        $this->dropTable('ActivityParam');
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
