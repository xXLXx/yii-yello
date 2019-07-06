<?php

use yii\db\Schema;
use yii\db\Migration;

class m150616_015822_DriverHasStore extends Migration
{
    public function up()
    {
        $this->createTable('DriverHasStore', [
            'id' => Schema::TYPE_PK,
            'driverId' => Schema::TYPE_INTEGER,
            'storeId' => Schema::TYPE_INTEGER,
            'createdAt' => Schema::TYPE_INTEGER . " NOT NULL DEFAULT 0",
            'updatedAt' => Schema::TYPE_INTEGER . " NOT NULL DEFAULT 0",
            'isInvitedByStoreOwner' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT 0",
            'isAcceptedByDriver' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'isArchived' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
        ]);
    }

    public function down()
    {
        $this->dropTable('DriverHasStore');
    }
}
