<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_090811_alter_shift_request_review extends Migration
{

    public function up()
    {
        $this->addColumn('ShiftRequestReview', 'deliveryCount', Schema::TYPE_INTEGER . ' DEFAULT 0');
        $this->addColumn('ShiftRequestReview', 'userId', Schema::TYPE_INTEGER);

        $this->addForeignKey('shiftRequestReview_userId', 'ShiftRequestReview', 'userId', 'User', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('shiftRequestReview_userId', 'ShiftRequestReview');

        $this->dropColumn('ShiftRequestReview', 'deliveryCount');
        $this->dropColumn('ShiftRequestReview', 'userId');
    }
    
}
