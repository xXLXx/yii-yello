<?php

use yii\db\Schema;
use yii\db\Migration;

class m150506_072754_Franchiser extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('Franchiser', [
            'id' => Schema::TYPE_PK,
            'companyId' => Schema::TYPE_INTEGER,
            'userId' => Schema::TYPE_INTEGER,
            'corporateScheduleId' => Schema::TYPE_INTEGER
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('Franchiser');
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
