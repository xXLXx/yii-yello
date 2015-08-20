<?php

use yii\db\Schema;
use yii\db\Migration;

class m150819_070356_convert_shift_start_end_to_utc extends Migration
{
    public function up()
    {
        $sql = 'UPDATE `shift`
                SET `start` = CONVERT_TZ(`start`, "+10:00", "+00:00"),
                `end` = CONVERT_TZ(`end`, "+10:00", "+00:00"),
                `actualStart` = CONVERT_TZ(`actualStart`, "+10:00", "+00:00"),
                `actualEnd` = CONVERT_TZ(`actualEnd`, "+10:00", "+00:00")';
        $this->execute($sql);
    }

    public function down()
    {
        echo "m150819_070356_convert_shift_start_end_to_utc cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
