<?php

use yii\db\Schema;
use yii\db\Migration;

class m150609_031846_VehicleLicenseNumberToStr extends Migration
{
    public function up()
    {
        $this->alterColumn('Vehicle', 'licenseNumber', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->alterColumn('Vehicle', 'licenseNumber', Schema::TYPE_INTEGER);
    }

}
