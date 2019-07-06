<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_045219_add_menu_aggregator_role extends Migration
{

    public function up()
    {
        $menuAggregatorRole = [
            'name' => 'menuAggregator',
            'title' => 'Menu Aggregator',
        ];

        $this->insert('Role', $menuAggregatorRole);
    }

    public function down()
    {
        $this->delete('Role', ['name' => 'menuAggregator']);
    }
    
}
