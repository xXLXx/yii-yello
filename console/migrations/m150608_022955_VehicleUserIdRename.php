<?php

use yii\db\Schema;
use yii\db\Migration;

class m150608_022955_VehicleUserIdRename extends Migration
{
    public function up()
    {
        $this->renameColumn('Vehicle', 'userId', 'driverId');
    }

    public function down()
    {
        $this->renameColumn('Vehicle', 'driverId', 'userId');
    }
}
