<?php

use yii\db\Schema;
use yii\db\Migration;

class m150512_051349_Currency extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('Currency', [
            'id'        => Schema::TYPE_PK,
            'title'     => Schema::TYPE_STRING,
            'symbol'    => Schema::TYPE_STRING,
            'code'      => Schema::TYPE_STRING,
            'rate'      => Schema::TYPE_DECIMAL
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('Currency');
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
