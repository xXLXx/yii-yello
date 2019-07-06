<?php

use yii\db\Schema;
use yii\db\Migration;

class m150506_063725_Driver extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('Driver', [
            'id'    => Schema::TYPE_PK,
            'driverLicenseNumber' => Schema::TYPE_STRING,
            'driverLicensePhoto' => Schema::TYPE_STRING,
            'cityId' => Schema::TYPE_INTEGER,
            'personalProfile' => Schema::TYPE_STRING,
            'emergencyContactName' => Schema::TYPE_STRING,
            'emergencyContactPhone' => Schema::TYPE_STRING,
            'availability' => Schema::TYPE_STRING . ' NOT NULL DEFAULT \'roamer\'',
            'isAllowedToWorkInAustralia' => Schema::TYPE_BOOLEAN,
            'isAccredited' => Schema::TYPE_BOOLEAN,
            'paymentMethod' => Schema::TYPE_STRING . ' NOT NULL DEFAULT \'direct\'',
            'rating' => Schema::TYPE_FLOAT,
            'status' => Schema::TYPE_STRING
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('Driver');
    }
}
