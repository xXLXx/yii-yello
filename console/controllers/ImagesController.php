<?php

namespace console\controllers;

use common\models\Company;
use common\models\Image;
use common\models\Role;
use common\models\Store;
use common\models\User;
use common\models\Vehicle;
use yii\helpers\Url;

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
        $users = User::find()->with(['image', 'role'])->all();
        foreach ($users as $user) {
            $sourceFile = '';
            if ($user->image && file_exists($localPath.$user->image->originalUrl)) {
                $sourceFile = $localPath.$user->image->originalUrl;
            } else {
                $temporaryFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid('profile', true).'.png';
                file_put_contents($temporaryFile, file_get_contents(Url::to(['/tracking/get-user-initials', 'id' => $user->id], true), false,
                    stream_context_create([
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                        ]
                    ])));
                $sourceFile = $temporaryFile;
            }

            print $sourceFile.' for '.$user->id.PHP_EOL;
            try {
                $user->uploadProfilePhoto($sourceFile);
            } catch (\Exception $e) {
                \Yii::error($e->getMessage());
                print 'ERROR :: '.$e->getMessage().PHP_EOL;
            }
        }

        $stores = Store::find()->with('image')->all();
        foreach ($stores as $store) {
            $sourceFile = $localPath.'/store_image.png';

            if ($store->image && file_exists($localPath.$store->image->originalUrl)) {
                $sourceFile = $localPath.$store->image->originalUrl;
            }

            print $sourceFile.' for store '.$store->id.PHP_EOL;
            try {
                $store->uploadLogo($sourceFile);
            } catch (\Exception $e) {
                \Yii::error($e->getMessage());
                print 'ERROR :: '.$e->getMessage().PHP_EOL;
            }
        }

        $vehicles = Vehicle::find()->with(['image', 'user'])->all();
        foreach ($vehicles as $vehicle) {
            if (!$vehicle->user) {
                continue;
            }

            $sourceFile = $localPath.'/vehicle.jpg';

            if ($vehicle->image && file_exists($localPath.$vehicle->image->originalUrl)) {
                $sourceFile = $localPath.$vehicle->image->originalUrl;
            }

            print $sourceFile.' for vehicle '.$vehicle->id.PHP_EOL;
            try {
                $vehicle->user->uploadVehiclePhoto($sourceFile);
            } catch (\Exception $e) {
                \Yii::error($e->getMessage());
                print 'ERROR :: '.$e->getMessage().PHP_EOL;
            }
        }

        $vehicles = Vehicle::find()->with(['licensePhoto', 'user'])->all();
        foreach ($vehicles as $vehicle) {
            if (!$vehicle->user) {
                continue;
            }

            $sourceFile = $localPath.'/Driverslicense.jpg';

            if ($vehicle->licensePhoto && file_exists($localPath.$vehicle->licensePhoto->originalUrl)) {
                $sourceFile = $localPath.$vehicle->licensePhoto->originalUrl;
            }

            print $sourceFile.' license photo for '.$vehicle->id.PHP_EOL;
            try {
                $vehicle->user->uploadLicensePhoto($sourceFile);
            } catch (\Exception $e) {
                \Yii::error($e->getMessage());
                print 'ERROR :: '.$e->getMessage().PHP_EOL;
            }
        }

        $companies = Company::find()->with('image')->all();
        foreach ($companies as $company) {
            $sourceFile = $localPath.'/store_image.png';

            if ($company->image && file_exists($localPath.$company->image->originalUrl)) {
                $sourceFile = $localPath.$company->image->originalUrl;
            }

            print $sourceFile.' for company '.$company->id.PHP_EOL;
            try {
                $company->uploadLogo($sourceFile);
            } catch (\Exception $e) {
                \Yii::error($e->getMessage());
                print 'ERROR :: '.$e->getMessage().PHP_EOL;
            }
        }

        return 0;
    }
}
