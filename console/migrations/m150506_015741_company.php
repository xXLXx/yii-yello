<?php

use yii\db\Schema;
use yii\db\Migration;

class m150506_015741_company extends Migration
{
    public function up()
    {
        $options = null;
        if($this->db->driverName == 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('Company', [
            'id' => Schema::TYPE_PK
        ], $options);
    }

    public function down()
    {
        $this->dropTable('Company');
    }
}
