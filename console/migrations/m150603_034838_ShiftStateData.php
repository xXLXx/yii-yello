<?php

use yii\db\Schema;
use yii\db\Migration;

class m150603_034838_ShiftStateData extends Migration
{
    /**
     * Get items
     * 
     * @return array
     */
    protected function _getItems()
    {
        $items = [
            [
                'name' => 'pending',
                'title' => 'Pending'
            ],
            [
                'name' => 'yelloAllocated',
                'title' => 'Yello Allocated'
            ],
            [
                'name' => 'allocated',
                'title' => 'Allocated'
            ],
            [
                'name' => 'Active',
                'title' => 'Active'
            ],
            [
                'name' => 'approval',
                'title' => 'Approval'
            ],
            [
                'name' => 'completed',
                'title' => 'Completed'
            ],
            [
                'name' => 'disputed',
                'title' => 'Disputed'
            ],
            [
                'name' => 'pendingPayment',
                'title' => 'Pending payment'
            ]
        ];
        return $items;
    }
    
    public function up()
    {
        $items = $this->_getItems();
        foreach ($items as $item) {
            $this->insert('ShiftState', $item);
        }
    }

    public function down()
    {
        $items = $this->_getItems();
        $names = \common\helpers\ArrayHelper::getColumn($items, 'name');
        $this->delete('ShiftState', [
            'name' => $names
        ]);
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
