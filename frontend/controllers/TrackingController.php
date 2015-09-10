<?php

namespace frontend\controllers;

use common\models\User;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Driver Map Controller
 *
 * @author -xXLXx-
 */
class TrackingController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['get-driver-marker', 'get-driver-initials-marker', 'get-user-initials'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ],
                ],
            ],
        ]);
    }

    /**
     * Map
     */
    public function actionIndex()
    {
        $storeOwner = \Yii::$app->user->identity->storeOwner;
        $currentStore = $storeOwner->storeCurrent;
        $store = [
            'id' => $currentStore->id,
            'position' => [$currentStore->address->latitude, $currentStore->address->longitude],
            'accessToken' => \Yii::$app->user->identity->accessToken
        ];

        // Is not used right now, use /v1/driver/active API
        // $drivers = User::find()
        //     ->innerJoinWith(['acceptedShifts'])
        //     ->andWhere([
        //         'storeId'   => $currentStore->id,
        //         'actualEnd' => null
        //     ])
        //     ->all();
        // $drivers = ArrayHelper::toArray($drivers);
        $drivers = [];

        $pubnub = [
            'publishKey' => \Yii::$app->params['pubnubPublishKey'],
            'subscribeKey' => \Yii::$app->params['pubnubSubscribeKey']
        ];

        return $this->render('index', compact('drivers', 'store', 'pubnub'));
    }

    /**
     * Get Driver marker from user id
     */
    public function actionGetDriverMarker()
    {
        $driverId = \Yii::$app->request->get('driverId');
        $driver = User::findOne($driverId);

        header('Content-Type: image/png');

        $marker = imagecreatefrompng(\Yii::getAlias('@webroot') . "/img/marker-driver.png");
        imageAlphaBlending($marker, true);
        imageSaveAlpha($marker, true);

        $defaultImg = \Yii::getAlias('@webroot') . "/img/Driver_Pic_bgrey_black.png";
        $imagePath = \Yii::$app->request->get('sourceFile', $defaultImg);

        // Only accept pngs and jpegs, else loads default
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileinfo = finfo_file($finfo, $imagePath);
        finfo_close($finfo);
        if ($fileinfo == 'image/jpeg') {
            $driverImg = imagecreatefromjpeg($imagePath);
        } else if ($fileinfo == 'image/png') {
            $driverImg = imagecreatefrompng($imagePath);
        } else {
            $driverImg = imagecreatefrompng($defaultImg);
        }

        // Scale driver image
        $driverImg = imagescale($driverImg, 99, 99);
        $driverImgW = imagesx($driverImg);
        $driverImgH = imagesy($driverImg);

        // prepare borders
        $borders = [
            [
                'size' => 114,
                'color' => [250, 208, 10],
                'position' => [24, 14]
            ],
            [
                'size' => 105,
                'color' => [255, 255, 255],
                'position' => [29, 18]
            ]
        ];
        // Create borders
        foreach ($borders as $borderOptions) {
            $borderW = $borderH = $borderOptions['size'];
            $border = imagecreatetruecolor($borderW, $borderH);
            $borderBlank = imagecreatetruecolor($borderW, $borderH);
            $borderBlankFill = imagecolorallocate($borderBlank, 0, 0, 0);
            imagefill($borderBlank, 0, 0, $borderBlankFill);

            $circleMask = imagecolorallocate($borderBlank, $borderOptions['color'][0], $borderOptions['color'][1], $borderOptions['color'][2]);
            $radius = $borderW <= $borderH ? $borderW : $borderH;
            imagefilledellipse ($borderBlank, ($borderW / 2), ($borderH / 2), $radius, $radius, $circleMask);

            // imagecolortransparent($borderBlank, $circleMask);
            imagecopymerge($border, $borderBlank, 0, 0, 0, 0, $borderW, $borderH, 100);

            imagecolortransparent($border, $borderBlankFill);

            // Merge border to marker
            imagecopymerge($marker, $border, $borderOptions['position'][0], $borderOptions['position'][1], 0, 0, $borderW, $borderH, 100);
        }

        // Crop driver image
        $blankImg = imagecreatetruecolor($driverImgW, $driverImgH);
        $blankImgFill = imagecolorallocate($blankImg, 255, 255, 255);
        imagefill($blankImg, 0, 0, $blankImgFill);

        $circleMask = imagecolorallocate($blankImg, 0, 0, 0);
        $radius = $driverImgW <= $driverImgH ? $driverImgW : $driverImgH;
        imagefilledellipse ($blankImg, ($driverImgW / 2), ($driverImgH / 2), $radius, $radius, $circleMask);

        imagecolortransparent($blankImg, $circleMask);
        imagecopymerge($driverImg, $blankImg, 0, 0, 0, 0, $driverImgW, $driverImgH, 100);

        imagecolortransparent($driverImg, $blankImgFill);

        // Merge driver image into marker
        imagecopymerge($marker, $driverImg, 32, 21, 0, 0, $driverImgW, $driverImgH, 100);

        // Resize merged images to marker size
        $h = imagesy($marker);
        $w = imagesx($marker);
        $newW = 135;
        $newH = (int) round(($h / $w) * $newW);
        // $marker = imagescale($marker, $newW, $newH);
        // Resample image to anitalias
        $smallMarker = imagecreatetruecolor($newW, $newH);
        imagecolortransparent($smallMarker, imagecolorallocatealpha($smallMarker, 0, 0, 0, 127));
        imagealphablending($smallMarker, false);
        imagesavealpha($smallMarker, true);
        imagecopyresampled($smallMarker, $marker, 0, 0, 0, 0, $newW, $newH, $w, $h);

        imagepng($smallMarker);

        imagedestroy($marker);
        imagedestroy($smallMarker);
        imagedestroy($blankImg);
        imagedestroy($driverImg);
    }

    /**
     * Generate driver marker with initials.
     */
    public function actionGetDriverInitialsMarker()
    {
        putenv('GDFONTPATH=' . \Yii::getAlias('@webroot/fonts'));
        $user = User::findOne(\Yii::$app->getRequest()->get('driverId'));
        header("Content-type: image/png");
        $string = substr($user->firstName, 0,1).substr($user->lastName,0,1);
        $im = imagecreatefrompng(\Yii::getAlias('@webroot') . "/img/marker-driver.png");
        $grey = imagecolorallocate($im, 128, 128, 128);
        $black = imagecolorallocate($im, 0, 0, 0);
        $px     = (imagesx($im) - 28 * strlen($string)) / 2;
        //imagestring($im, 50, $px, 40, $string, $orange);
        imagettftext($im, 44, 0, $px-2, 93, $black, 'DejaVuSans-Bold.ttf', $string);
        imagettftext($im, 44, 0, $px, 91, $grey, 'DejaVuSans-Bold.ttf', $string);
        imagepng($im);
        imagedestroy($im);
    }

    /**
     * Generate default photo/thumb with initials.
     */
    public function actionGetUserInitials()
    {
        putenv('GDFONTPATH=' . \Yii::getAlias('@webroot/fonts'));
        $user = User::findOne(\Yii::$app->getRequest()->get('id'));
        header("Content-type: image/png");
        $string = strtoupper($user->firstName[0].$user->lastName[0]); //substr($user->firstName, 0, 1).substr($user->lastName, 0,1);
        $im = imagecreatefrompng(\Yii::getAlias('@webroot') . "/img/default-initials-template.png");
        $grey = imagecolorallocate($im, 128, 128, 128);
        $black = imagecolorallocate($im, 0, 0, 0);
        $px     = (imagesx($im) - 42 * strlen($string)) / 2;
        //imagestring($im, 50, $px, 40, $string, $orange);
        imagettftext($im, 44, 0, $px-2, 80, $black, 'DejaVuSans-Bold.ttf', $string);
        imagettftext($im, 44, 0, $px, 78, $grey, 'DejaVuSans-Bold.ttf', $string);
        imagepng($im);
        imagedestroy($im);
    }
}
