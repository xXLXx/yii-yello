<?php

use yii\db\Schema;
use yii\db\Migration;

class m150618_063454_ForeignKeys extends Migration
{
    public function safeUp()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->truncateTable('ShiftRequestReview');
        $this->truncateTable('Shift');
        $this->truncateTable('Company');
        $this->truncateTable('StoreOwner');
        $this->truncateTable('ShiftHasDriver');
        $this->truncateTable('UserDriver');
        $this->truncateTable('Role');
        $this->truncateTable('User');
        $this->truncateTable('Image');
        $this->truncateTable('DriverHasStore');
        $this->truncateTable('DriverHasSuburb');
        $this->truncateTable('City');
        $this->truncateTable('ShiftState');
        $this->truncateTable('VehicleType');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
        
        $this->addForeignKey('user_roleId', 'User', 'roleId', 'Role', 'id');
        $this->addForeignKey('user_imageId', 'User', 'imageId', 'Image', 'id');
        
        $this->addForeignKey('userDriver_cityId', 'UserDriver', 'cityId', 'City', 'id');
        $this->addForeignKey('userDriver_userId', 'UserDriver', 'userId', 'User', 'id');
        
        $this->addForeignKey('vehicle_vechicleTypeId', 'Vehicle', 'vehicleTypeId', 'VehicleType', 'id');
        $this->addForeignKey('vehicle_imageId', 'Vehicle', 'imageId', 'Image', 'id');
        $this->addForeignKey('vehicle_driverId', 'Vehicle', 'driverId', 'User', 'id');
        $this->addForeignKey('vehicle_licensePhotoId', 'Vehicle', 'licensePhotoId', 'Image', 'id');
        
        $this->addForeignKey('suburb_cityId', 'Suburb', 'cityId', 'City', 'id');
        
        $this->addForeignKey('storeOwner_companyId', 'StoreOwner', 'companyId', 'Company', 'id');
        $this->addForeignKey('storeOwner_franchiserId', 'StoreOwner', 'franchiserId', 'Franchiser', 'id');
        $this->addForeignKey('storeOwner_userId', 'StoreOwner', 'userId', 'User', 'id');
        
        $this->addForeignKey('store_businessTypeId', 'Store', 'businessTypeId', 'BusinessType', 'id');
        $this->addForeignKey('store_storeOwnerId', 'Store', 'storeOwnerId', 'StoreOwner', 'id');
        $this->alterColumn('Store', 'stateId', Schema::TYPE_INTEGER);
        $this->update('Store', ['stateId' => NULL]);
        $this->addForeignKey('store_stateId', 'Store', 'stateId', 'State', 'id');
        $this->addForeignKey('store_imageId', 'Store', 'imageId', 'Image', 'id');
        $this->addForeignKey('store_companyId', 'Store', 'companyId', 'Company', 'id');
        
        $this->addForeignKey('state_countryId', 'State', 'countryId', 'Country', 'id');
        
        $this->addForeignKey('shiftRequestReview_shiftId', 'ShiftRequestReview', 'shiftId', 'Shift', 'id');
        
        $this->addForeignKey('shiftHasDriver_shiftId', 'ShiftHasDriver', 'shiftId', 'Shift', 'id');
        $this->addForeignKey('shiftHasDriver_driverId', 'ShiftHasDriver', 'driverId', 'User', 'id');
        
        $this->addForeignKey('shift_storeId', 'Shift', 'storeId', 'Store', 'id');
        $this->addForeignKey('shift_shiftStateId', 'Shift', 'shiftStateId', 'ShiftState', 'id');
        
        $this->addForeignKey('franchiser_companyId', 'Franchiser', 'companyId', 'Company', 'id');
        $this->addForeignKey('franchiser_userId', 'Franchiser', 'userId', 'User', 'id');
        
        $this->addForeignKey('driverHasSuburb_driverId', 'DriverHasSuburb', 'driverId', 'User', 'id');
        $this->addForeignKey('driverHasSuburb_suburbId', 'DriverHasSuburb', 'suburbId', 'Suburb', 'id');
        
        $this->addForeignKey('driverHasStore_driverId', 'DriverHasStore', 'driverId', 'User', 'id');
        $this->addForeignKey('driverHasStore_storeId', 'DriverHasStore', 'storeId', 'Store', 'id');
        
        $this->addForeignKey('company_stateId', 'Company', 'stateId', 'State', 'id');
        $this->addForeignKey('company_countryId', 'Company', 'countryId', 'Country', 'id');
        $this->addForeignKey('company_timeZoneId', 'Company', 'timeZoneId', 'TimeZone', 'id');
        $this->addForeignKey('company_timeFormatId', 'Company', 'timeFormatId', 'TimeFormat', 'id');
        $this->addForeignKey('company_currencyId', 'Company', 'currencyId', 'Currency', 'id');
        
        $this->addForeignKey('city_stateId', 'City', 'stateId', 'State', 'id');
        
        $this->addRoles();
        $this->addShiftStates();
        $this->addVehicleTypes();
    }
    
    public function addVehicleTypes()
    {
        $items = [
            [
                'name'  => 'car',
                'title' => 'Car',
            ],
            [
                'name'  => 'bike',
                'title' => 'Bike',
            ]
        ];
        foreach ($items as $item) {
            $this->insert('VehicleType', $item);
        }
    }
    
    public function addShiftStates()
    {
        $items = [
            [
                'name' => 'pending',
                'title' => 'Pending',
                'color' => 'red'
            ],
            [
                'name' => 'yelloAllocated',
                'title' => 'Yello Allocated',
                'color' => 'yellow'
            ],
            [
                'name' => 'allocated',
                'title' => 'Allocated',
                'color' => ''
            ],
            [
                'name' => 'active',
                'title' => 'Active',
                'color' => 'blue'
            ],
            [
                'name' => 'approval',
                'title' => 'Awaiting approval',
                'color' => 'violet'
            ],
            [
                'name' => 'completed',
                'title' => 'Completed',
                'color' => 'green'
            ],
            [
                'name' => 'disputed',
                'title' => 'Disputed',
                'color' => ''
            ],
            [
                'name' => 'pendingPayment',
                'title' => 'Pending payment',
                'color' => ''
            ]
        ];
        foreach ($items as $item) {
            $this->insert('ShiftState', $item);
        }
    }
    
    public function addRoles()
    {
        $roles = [
            [
                'name'  => 'superAdmin',
                'title' => 'Super Admin'
            ],
            [
                'name'  => 'franchiser',
                'title' => 'Franchiser'
            ],
            [
                'name'  => 'driver',
                'title' => 'Driver'
            ],
            [
                'name'  => 'manager',
                'title' => 'Manager'
            ],
            [
                'name'  => 'user',
                'title' => 'User'
            ],
            [
                'name'  => 'yelloAdmin',
                'title' => 'Yello Admin'
            ]
        ];
        foreach ($roles as $item) {
            $this->insert('Role', $item);
        }
        
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

    public function safeDown()
    {
        $this->dropForeignKey('user_roleId', 'User');
        $this->dropForeignKey('user_imageId', 'User');
        
        $this->dropForeignKey('userDriver_cityId', 'UserDriver');
        $this->dropForeignKey('userDriver_userId', 'UserDriver');
        
        $this->dropForeignKey('vehicle_vechicleTypeId', 'Vehicle');
        $this->dropForeignKey('vehicle_imageId', 'Vehicle');
        $this->dropForeignKey('vehicle_driverId', 'Vehicle');
        $this->dropForeignKey('vehicle_licensePhotoId', 'Vehicle');
        
        $this->dropForeignKey('suburb_cityId', 'Suburb');
        
        $this->dropForeignKey('storeOwner_companyId', 'StoreOwner');
        $this->dropForeignKey('storeOwner_franchiserId', 'StoreOwner');
        $this->dropForeignKey('storeOwner_userId', 'StoreOwner');
        
        $this->dropForeignKey('store_businessTypeId', 'Store');
        $this->dropForeignKey('store_storeOwnerId', 'Store');
        $this->dropForeignKey('store_stateId', 'Store');
        $this->dropForeignKey('store_imageId', 'Store');
        $this->dropForeignKey('store_companyId', 'Store');
        
        $this->dropForeignKey('state_countryId', 'State');
        
        $this->dropForeignKey('shiftRequestReview_shiftId', 'ShiftRequestReview');
        
        $this->dropForeignKey('shiftHasDriver_shiftId', 'ShiftHasDriver');
        $this->dropForeignKey('shiftHasDriver_driverId', 'ShiftHasDriver');
        
        $this->dropForeignKey('shift_storeId', 'Shift');
        $this->dropForeignKey('shift_shiftStateId', 'Shift');
        
        $this->dropForeignKey('franchiser_companyId', 'Franchiser');
        $this->dropForeignKey('franchiser_userId', 'Franchiser');
        
        $this->dropForeignKey('driverHasSuburb_driverId', 'DriverHasSuburb');
        $this->dropForeignKey('driverHasSuburb_suburbId', 'DriverHasSuburb');
        
        $this->dropForeignKey('driverHasStore_driverId', 'DriverHasStore');
        $this->dropForeignKey('driverHasStore_storeId', 'DriverHasStore');
        
        $this->dropForeignKey('company_stateId', 'Company');
        $this->dropForeignKey('company_countryId', 'Company');
        $this->dropForeignKey('company_timeZoneId', 'Company');
        $this->dropForeignKey('company_timeFormatId', 'Company');
        $this->dropForeignKey('company_currencyId', 'Company');
        
        $this->dropForeignKey('city_stateId', 'City');
    }
}
