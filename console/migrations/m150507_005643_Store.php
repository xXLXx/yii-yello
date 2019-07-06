<?php

use yii\db\Schema;
use yii\db\Migration;

class m150507_005643_Store extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('Store', [
            'id'        => Schema::TYPE_PK,
            'title'  => Schema::TYPE_STRING,
            'businessTypeId' => Schema::TYPE_INTEGER, 
            'companyId' => Schema::TYPE_INTEGER,
            'storeOwnerId' => Schema::TYPE_INTEGER,
            'paymentScheduleId' => Schema::TYPE_INTEGER
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('Store');
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
