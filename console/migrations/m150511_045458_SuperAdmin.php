<?php

use yii\db\Schema;
use yii\db\Migration;

class m150511_045458_SuperAdmin extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('SuperAdmin', [
            'id' => Schema::TYPE_PK,
            'yelloCompanyId' => Schema::TYPE_INTEGER
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('SuperAdmin');
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
