<?php

use yii\db\Schema;
use yii\db\Migration;

class m150511_050011_StoreOwner extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('StoreOwner', [
            'id' => Schema::TYPE_PK,
            'companyId'     => Schema::TYPE_INTEGER,
            'franchiserId'  => Schema::TYPE_INTEGER
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('StoreOwner');
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
