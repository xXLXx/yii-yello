<?php

use yii\db\Schema;
use yii\db\Migration;

class m150610_063346_ShiftAddIsFavourites extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn(
            'Shift', 'isFavourites', Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        );
    }
    
    public function safeDown()
    {
        $this->dropColumn('Shift', 'isFavourites');
    }
}
