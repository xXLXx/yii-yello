<?php

use yii\db\Schema;
use yii\db\Migration;

class m150519_034611_BusinessType extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('BusinessType', [
            'id'        => Schema::TYPE_PK,
            'title'  => Schema::TYPE_STRING,
            'isArchived' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0'
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('BusinessType');
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
