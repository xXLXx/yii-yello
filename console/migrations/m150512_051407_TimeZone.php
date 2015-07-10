<?php

use yii\db\Schema;
use yii\db\Migration;

class m150512_051407_TimeZone extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('TimeZone', [
            'id'    => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'zone'  => Schema::TYPE_STRING,
            'code'  => Schema::TYPE_STRING,
            'text'  => Schema::TYPE_STRING,
            'isDst' => Schema::TYPE_BOOLEAN
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('TimeZone');
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
