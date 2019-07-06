<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_033943_create_ShiftStateLog extends Migration
{

//    public function up()
//    {
//    }

    public function down()
    {
        $this->dropTable('ShiftStateLog');
    }

    public function safeUp()
    {
        $this->createTable('ShiftStateLog', [
            'id' => Schema::TYPE_PK,
            'shiftId' => Schema::TYPE_INTEGER,
            'shiftStateId' => Schema::TYPE_INTEGER,
            'isArchived' => (Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT 0"),
            'createdAt' => Schema::TYPE_INTEGER,
        ]);
        $this->addForeignKey(
            'fk_ShiftStateLog_shiftId_Shift_id',
            'ShiftStateLog',
            'shiftId',
            'Shift',
            'id',
            'SET NULL',
            'SET NULL'
        );
        $this->addForeignKey(
            'fk_ShiftStateLog_shiftStateId_ShiftState_id',
            'ShiftStateLog',
            'shiftStateId',
            'ShiftState',
            'id',
            'SET NULL',
            "SET NULL"
        );
    }


    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeDown()
    {
    }
    */
}
