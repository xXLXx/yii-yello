<?php

use yii\db\Schema;
use yii\db\Migration;

class m150618_081415_ShiftHasDriver_add_isDeclinedByStoreOwner extends Migration
{
    public function up()
    {
        $this->addColumn('ShiftHasDriver', 'isDeclinedByStoreOwner', Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT false");
    }

    public function down()
    {
        $this->dropColumn('ShiftHasDriver', 'isDeclinedByStoreOwner');
    }
}
