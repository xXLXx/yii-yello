<?php

use yii\db\Schema;
use yii\db\Migration;

class m150506_115213_Shift extends Migration
{
    public function up()
    {
        $options = null;
        if ($this->db->driverName === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('Shift', [
            'id' => Schema::TYPE_PK,
            'start' => Schema::TYPE_DATETIME,
            'end' => Schema::TYPE_DATETIME,
            'isVehicleProvided' => Schema::TYPE_BOOLEAN,
            'isYelloDrivers' => Schema::TYPE_BOOLEAN,
            'isMyDrivers' => Schema::TYPE_BOOLEAN,
            'approvedApplicationId' => Schema::TYPE_STRING,
        ], $options);
    }

    public function down()
    {
        $this->dropTable('Shift');
    }
}
