<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_111515_add_shift_state_under_review extends Migration
{

    public function up()
    {
        $this->insert('ShiftState', [
            'name' => 'underReview',
            'title' => 'Under review',
        ]);
    }

    public function down()
    {
        $this->delete('ShiftState', ['name' => 'underReview']);
    }
    
}
