<?php

use yii\db\Schema;
use yii\db\Migration;

class m150513_074443_SuperAdminUser extends Migration
{
    public function up()
    {
        $roleQuery = new yii\db\Query();
        $role = $roleQuery
            ->select('id')
            ->from('Role')
            ->andWhere(['name' => 'superAdmin'])
                ->one();
        $this->insert('User', [
            'passwordHash' => \Yii::$app->security->generatePasswordHash('1234567'),
            'roleId' => $role['id'],
            'email' => 'superadmin@admin.com',
            'firstName' => 'Super',
            'lastName' => 'Admin'
        ]);
    }

    public function down()
    {
        $roleQuery = new yii\db\Query();
        $role = $roleQuery->select('id')
            ->from('Role')
            ->andWhere(['name' => 'superAdmin'])
                ->one();
        $this->delete('User', ['roleId' => $role['id']]);
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
