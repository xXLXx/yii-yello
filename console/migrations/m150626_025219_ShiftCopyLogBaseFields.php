<?php

use yii\db\Schema;
use yii\db\Migration;

class m150626_025219_ShiftCopyLogBaseFields extends Migration
{
    public function up()
    {
        $this->addColumn('ShiftCopyLog', 'createdAt', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('ShiftCopyLog', 'updatedAt', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('ShiftCopyLog', 'isArchived', Schema::TYPE_BOOLEAN . ' DEFAULT 0');
        $this->addColumn('ShiftCopyLog', 'shiftCopyId', Schema::TYPE_INTEGER);
        $this->addForeignKey(
            'shiftCopyLog_shiftCopyId', 'ShiftCopyLog', 'shiftCopyId', 
            'Shift', 'id', 'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropColumn('ShiftCopyLog', 'createdAt');
        $this->dropColumn('ShiftCopyLog', 'updatedAt');
        $this->dropColumn('ShiftCopyLog', 'isArchived');
        $this->dropForeignKey('shiftCopyLog_shiftCopyId', 'ShiftCopyLog');
        $this->dropColumn('ShiftCopyLog', 'shiftCopyId');
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
