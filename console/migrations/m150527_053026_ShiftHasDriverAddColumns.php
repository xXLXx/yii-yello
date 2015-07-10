<?php

use yii\db\Schema;
use yii\db\Migration;

class m150527_053026_ShiftHasDriverAddColumns extends Migration
{
    public function up()
    {
        $this->addColumn(
            'ShiftHasDriver',
            'acceptedByStoreOwner',
            Schema::TYPE_BOOLEAN . " default false after updatedAt"
        );
    }

    public function down()
    {
        $this->dropColumn('ShiftHasDriver', 'acceptedByStoreOwner');
    }
}
