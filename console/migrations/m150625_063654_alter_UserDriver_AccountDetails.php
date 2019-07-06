<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_063654_alter_UserDriver_AccountDetails extends Migration
{
    protected function getColumns()
    {
        return [
            'isAllowedToReceiveNotifications' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT 0",
            'isAvailableToWork' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT 0",
        ];
    }

    public function safeUp()
    {
        $columns = $this->getColumns();
        foreach ($columns as $name => $type) {
            $this->addColumn('UserDriver', $name, $type);
        }
    }

    public function safeDown()
    {
        $columns = $this->getColumns();
        foreach ($columns as $name => $type) {
            $this->dropColumn('UserDriver', $name);
        }
    }
}
