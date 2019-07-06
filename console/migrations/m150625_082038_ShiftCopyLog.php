<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_082038_ShiftCopyLog extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('ShiftCopyLog', [
            'id' => Schema::TYPE_PK,
            'shiftId' => Schema::TYPE_INTEGER,
            'hash'  => Schema::TYPE_STRING
        ], $tableOptions);
        $this->addForeignKey(
            'shiftCopyLog_shiftId', 'ShiftCopyLog', 'shiftId', 'Shift', 'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('shiftCopyLog_shiftId', 'ShiftCopyLog');
        $this->dropTable('ShiftCopyLog');
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
