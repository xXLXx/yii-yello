<?php

use yii\db\Schema;
use yii\db\Migration;

class m150512_051343_State extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('State', [
            'id' => Schema::TYPE_PK,
            'countryId' => Schema::TYPE_INTEGER,
            'title' => Schema::TYPE_STRING
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('State');
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
