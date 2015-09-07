<?php
namespace frontend\controllers;

use common\models\Company;
use common\models\DriverHasStore;
use common\models\Role;
use common\models\Shift;
use common\models\ShiftHasDriver;
use common\models\Store;
use common\models\StoreOwnerFavouriteDrivers;
use common\models\User;
use common\models\UserHasStore;
use yii\db\Query;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class ImagesController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public $layout = false;

    public $client;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->client = \Aws\S3\S3Client::factory([
            'key' => \Yii::$app->params['aws_access_key'],
            'secret' => \Yii::$app->params['aws_access_secret'],
        ]);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['profile', 'profile-thumb', 'profile-map', 'vehicle', 'vehicle-thumb'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (\Yii::$app->user->isGuest) {
                                return false;
                            }

                            // Of course,
                            if (\Yii::$app->user->identity->role->name == Role::ROLE_SUPER_ADMIN) {
                                return true;
                            }

                            $userId = \Yii::$app->getRequest()->get('userId');

                            // Allow himself
                            if ($userId === \Yii::$app->user->id) {
                                return true;
                            }

                            // Allow storeowner
                            if (\Yii::$app->user->identity->role->name == Role::ROLE_STORE_OWNER) {
                                $storeIds = UserHasStore::find()->select('storeId')->where(['userId' => \Yii::$app->user->id])->column();
                                if (empty($storeIds)) {
                                    return false;
                                }

                                // my drivers
                                if (count(DriverHasStore::find()->where(['driverId' => $userId, 'storeId' => $storeIds])->count()) > 0) {
                                    return true;
                                }

                                // faves
                                if (count(StoreOwnerFavouriteDrivers::find()->where(['driverId' => $userId, 'storefk' => $storeIds])->count()) > 0) {
                                    return true;
                                }

                                // applied for shifts
                                if (count(Shift::find()->joinWith(['shiftHasDrivers'], true, 'RIGHT JOIN')
                                        ->where(['storeId' => $storeIds, 'driverId' => $userId])->count()) > 0) {
                                    return true;
                                }

                            }

                            return false;
                        }
                    ],
                    [
                        'actions' => ['dl'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (\Yii::$app->user->isGuest) {
                                return false;
                            }

                            // Of course,
                            if (\Yii::$app->user->identity->role->name == Role::ROLE_SUPER_ADMIN) {
                                return true;
                            }

                            // Allow himself
                            if (\Yii::$app->getRequest()->get('userId') === \Yii::$app->user->id) {
                                return true;
                            }

                            return false;
                        }
                    ],
                    [
                        'actions' => ['store-logo', 'company-logo'],
                        'allow' => true,
                    ]
                ],
            ],
        ];
    }

    /**
     * The profile photo
     */
    public function actionProfile()
    {
        $user = User::findOne(\Yii::$app->getRequest()->get('id'));
        $signedUrl = $this->client->getObjectUrl(\Yii::$app->params['aws_files_bucket'], $user->getProfilePhotoPath(), '+2 minutes');
        $headers = @get_headers($signedUrl);
        // that dont exist
        if (strpos($headers[0],'404') !== false) {
            if ($user->role->name == Role::ROLE_DRIVER) {
                $signedUrl = \Yii::getAlias('@web/img/').'Driver_Pic_bgrey_black.png';
            } else {
                $signedUrl = \Yii::getAlias('@web/img/').'shop_white_front.png';
            }
        }

        return $this->redirect($signedUrl);

//        $image = imagecreatefrompng($signedUrl);
//
//        header('Content-Type: image/png');
//
//        imagepng($image);
//        imagedestroy($image);
    }

    /**
     * The profile photo thumb
     */
    public function actionProfileThumb()
    {
        $user = User::findOne(\Yii::$app->getRequest()->get('id'));
        $signedUrl = $this->client->getObjectUrl(\Yii::$app->params['aws_files_bucket'], $user->getProfilePhotoThumbPath(), '+2 minutes');
        $headers = @get_headers($signedUrl);
        // that dont exist
        if (strpos($headers[0],'404') !== false) {
            if ($user->role->name == Role::ROLE_DRIVER) {
                $signedUrl = \Yii::getAlias('@web/img/').'Driver_Pic_bgrey_black.png';
            } else {
                $signedUrl = \Yii::getAlias('@web/img/').'shop_white_front.png';
            }
        }

        return $this->redirect($signedUrl);

//        $image = imagecreatefrompng($signedUrl);
//
//        header('Content-Type: image/png');
//
//        imagepng($image);
//        imagedestroy($image);
    }

    /**
     * The profile map photo marker
     */
    public function actionProfileMap()
    {
        $user = User::findOne(\Yii::$app->getRequest()->get('id'));
        $signedUrl = $this->client->getObjectUrl(\Yii::$app->params['aws_files_bucket'], $user->getProfileMapPhotoPath(), '+2 minutes');
        $headers = @get_headers($signedUrl);
        // that dont exist
        if (strpos($headers[0],'404') !== false) {
            $signedUrl = \Yii::getAlias('@web/img/').'marker-driver.png';
        }

        return $this->redirect($signedUrl);

//        $image = imagecreatefrompng($signedUrl);
//
//        header('Content-Type: image/png');
//
//        imagepng($image);
//        imagedestroy($image);
    }

    /**
     * The driver's license
     */
    public function actionDl()
    {
        $user = User::findOne(\Yii::$app->getRequest()->get('id'));
        $signedUrl = $this->client->getObjectUrl(\Yii::$app->params['aws_files_bucket'], $user->getLicensePhotoPath(), '+2 minutes');

        return $this->redirect($signedUrl);

//        $image = imagecreatefrompng($signedUrl);
//
//        header('Content-Type: image/png');
//
//        imagepng($image);
//        imagedestroy($image);
    }

    /**
     * The vehicle registration
     */
    public function actionVehicle()
    {
        $user = User::findOne(\Yii::$app->getRequest()->get('id'));
        $signedUrl = $this->client->getObjectUrl(\Yii::$app->params['aws_files_bucket'], $user->getVehicleRegistrationPhotoPath(), '+2 minutes');

        return $this->redirect($signedUrl);

//        $image = imagecreatefrompng($signedUrl);
//
//        header('Content-Type: image/png');
//
//        imagepng($image);
//        imagedestroy($image);
    }

    /**
     * The vehicle registration thumb
     */
    public function actionVehicleThumb()
    {
        $user = User::findOne(\Yii::$app->getRequest()->get('id'));
        $signedUrl = $this->client->getObjectUrl(\Yii::$app->params['aws_files_bucket'], $user->getVehicleRegistrationPhotoThumbPath(), '+2 minutes');

        return $this->redirect($signedUrl);

//        $image = imagecreatefrompng($signedUrl);
//
//        header('Content-Type: image/png');
//
//        imagepng($image);
//        imagedestroy($image);
    }

    /**
     * The store logo
     */
    public function actionStoreLogo()
    {
        $store = Store::findOne(\Yii::$app->getRequest()->get('id'));
        $signedUrl = $this->client->getObjectUrl(\Yii::$app->params['aws_files_bucket'], $store->getLogoPath(), '+2 minutes');
        $headers = @get_headers($signedUrl);
        // that dont exist
        if (strpos($headers[0],'404') !== false) {
            $signedUrl = \Yii::getAlias('@webroot/img/').'store_image.png';
        }

        return $this->redirect($signedUrl);

//        $image = imagecreatefrompng($signedUrl);
//
//        header('Content-Type: image/png');
//
//        imagepng($image);
//        imagedestroy($image);
    }

    /**
     * The company logo
     */
    public function actionCompanyLogo()
    {
        $company = Company::findOne(\Yii::$app->getRequest()->get('id'));
        $signedUrl = $this->client->getObjectUrl(\Yii::$app->params['aws_files_bucket'], $company->getLogoPath(), '+2 minutes');
        $headers = @get_headers($signedUrl);
        // that dont exist
        if (strpos($headers[0],'404') !== false) {
            $signedUrl = \Yii::getAlias('@webroot/img/').'store_image.png';
        }


        $image = imagecreatefrompng($signedUrl);

        header('Content-Type: image/png');

        imagepng($image);
        imagedestroy($image);
    }
}
