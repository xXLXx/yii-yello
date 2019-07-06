<?php

use yii\db\Schema;
use yii\db\Migration;

class m150506_050439_company_add_fields extends Migration
{
    public function up()
    {
        $this->addColumn('Company', 'companyName', Schema::TYPE_STRING);
        $this->addColumn('Company', 'address1', Schema::TYPE_STRING);
        $this->addColumn('Company', 'address2', Schema::TYPE_STRING);
        $this->addColumn('Company', 'suburb', Schema::TYPE_SMALLINT . ' Default 0');
        $this->addColumn('Company', 'stateId', Schema::TYPE_INTEGER);
        $this->addColumn('Company', 'contactPerson', Schema::TYPE_TEXT);
        $this->addColumn('Company', 'phone', Schema::TYPE_STRING);
        $this->addColumn('Company', 'website', Schema::TYPE_STRING);
        $this->addColumn('Company', 'ABN', Schema::TYPE_STRING);
        $this->addColumn('Company', 'logo', Schema::TYPE_STRING);
        $this->addColumn('Company', 'email', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('Company', 'companyName');
        $this->dropColumn('Company', 'address1');
        $this->dropColumn('Company', 'address2');
        $this->dropColumn('Company', 'suburb');
        $this->dropColumn('Company', 'stateId');
        $this->dropColumn('Company', 'contactPerson');
        $this->dropColumn('Company', 'phone');
        $this->dropColumn('Company', 'website');
        $this->dropColumn('Company', 'ABN');
        $this->dropColumn('Company', 'logo');
        $this->dropColumn('Company', 'email');
    }
}
