<?php

use yii\db\Schema;
use yii\db\Migration;

class m150605_082306_ShiftAddColumnsDeliveryCountPayment extends Migration
{
    public function up()
    {
        $this->addColumn('Shift', 'deliveryCount', Schema::TYPE_INTEGER . " NOT NULL DEFAULT 0");
        $this->addColumn('Shift', 'payment', Schema::TYPE_INTEGER . " NOT NULL DEFAULT 0");
    }

    public function down()
    {
        $this->dropColumn('Shift', 'deliveryCount');
        $this->dropColumn('Shift', 'payment');
    }
}
