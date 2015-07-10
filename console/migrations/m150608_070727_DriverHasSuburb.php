<?php

use yii\db\Schema;
use yii\db\Migration;

class m150608_070727_DriverHasSuburb extends Migration
{
    public function safeUp()
    {
        $options = null;
        if ($this->db->driverName === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        } 
        $this->createTable(
            'DriverHasSuburb', 
            [
                'id' => Schema::TYPE_PK,
                'driverId'   => Schema::TYPE_INTEGER,
                'suburbId'   => Schema::TYPE_INTEGER,
                'createdAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
                'updatedAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
                'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
            ], 
            $options
        );
    }

    public function safeDown()
    {
        $this->dropTable('DriverHasSuburb');
    }
}
