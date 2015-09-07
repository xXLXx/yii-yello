<?php

namespace console\controllers;

use common\models\Company;
use common\models\Image;
use common\models\Store;
use common\models\User;
use common\models\Vehicle;

/**
 * For console commands acting on Images.
 */
class ImagesController extends \yii\console\Controller
{
    /**
     * Migrates existing files to the cloud -- S3.
     * 1. Retrieve all user records with a linked image
     * then use that related image for upload.
     * 2. Check if image did exist locally.
     * 3. Do the same for stores.
     * 4. And vehicles.
     * 5. And companies.
     *
     * ~~~
     * php yii images/migrate
     * ~~~
     * 
     * @return int
     */
    public function actionMigrate()
    {
        $localPath = \Yii::getAlias('@frontend/web');
        $users = User::find()->joinWith('image', true, 'RIGHT JOIN')->all();
        print 'Users images found in db: '.count($users).PHP_EOL;
        foreach ($users as $user) {
            $sourceFile = $localPath.$user->image->originalUrl;
            if (!file_exists($sourceFile)) {
                print $sourceFile.' does not exist!'.PHP_EOL;
                continue;
            }

            print $sourceFile.' found  for '.$user->username.PHP_EOL;
            try {
                $user->uploadProfilePhoto($sourceFile);
            } catch (\Exception $e) {
                \Yii::error($e->getMessage());
            }
        }

        $stores = Store::find()->joinWith('image', true, 'RIGHT JOIN')->all();
        print 'Store images found in db: '.count($stores).PHP_EOL;
        foreach ($stores as $store) {
            $sourceFile = $localPath.$store->image->originalUrl;
            if (!file_exists($sourceFile)) {
                print $sourceFile.' does not exist!'.PHP_EOL;
                continue;
            }

            print $sourceFile.' found.'.PHP_EOL;
            try {
                $store->uploadLogo($sourceFile);
            } catch (\Exception $e) {
                \Yii::error($e->getMessage());
            }
        }

        $vehicles = Vehicle::find()->joinWith(['image', 'user'], true, 'RIGHT JOIN')->all();
        print 'Vehicle registration images found in db: '.count($vehicles).PHP_EOL;
        foreach ($vehicles as $vehicle) {
            $sourceFile = $localPath.$vehicle->image->originalUrl;
            if (!file_exists($sourceFile)) {
                print $sourceFile.' does not exist!'.PHP_EOL;
                continue;
            }

            print $sourceFile.' found.'.PHP_EOL;
            try {
                $vehicle->user->uploadVehiclePhoto($sourceFile);
            } catch (\Exception $e) {
                \Yii::error($e->getMessage());
            }
        }

        $vehicles = Vehicle::find()->joinWith(['licensePhoto', 'user'], true, 'RIGHT JOIN')->all();
        print 'Vehicle license images found in db: '.count($vehicles).PHP_EOL;
        foreach ($vehicles as $vehicle) {
            $sourceFile = $localPath.$vehicle->licensePhoto->originalUrl;
            if (!file_exists($sourceFile)) {
                print $sourceFile.' does not exist!'.PHP_EOL;
                continue;
            }

            print $sourceFile.' found.'.PHP_EOL;
            try {
                $vehicle->user->uploadLicensePhoto($sourceFile);
            } catch (\Exception $e) {
                \Yii::error($e->getMessage());
            }
        }

        $companies = Company::find()->joinWith('image', true, 'RIGHT JOIN')->all();
        print 'Company images found in db: '.count($companies).PHP_EOL;
        foreach ($companies as $company) {
            $sourceFile = $localPath.$company->image->originalUrl;
            if (!file_exists($sourceFile)) {
                print $sourceFile.' does not exist!'.PHP_EOL;
                continue;
            }

            print $sourceFile.' found.'.PHP_EOL;
            try {
                $company->uploadLogo($sourceFile);
            } catch (\Exception $e) {
                \Yii::error($e->getMessage());
            }
        }

        return 0;
    }
}
