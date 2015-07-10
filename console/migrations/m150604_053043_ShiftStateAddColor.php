<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_053043_ShiftStateAddColor extends Migration
{
    public function up()
    {
        $this->addColumn('ShiftState', 'color', Schema::TYPE_STRING);
        $items = [
            'allocated' => '',
            'yelloAllocated' => 'yellow',
            'pending'   => 'red',
            'completed' => 'green',
            'active' => 'blue',
            'approval' => 'violet',
            'disputed' => '',
            'pendingPayment' => ''
        ];
        foreach ($items as $key => $item) {
            $this->update('ShiftState', 
                [
                    'color' => $item
                ], 
                [
                    'name' => $key
                ]
            );
        }
    }

    public function down()
    {
        $this->dropColumn('ShiftState', 'color');
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
