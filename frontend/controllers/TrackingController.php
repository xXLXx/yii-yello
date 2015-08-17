<?php

namespace frontend\controllers;

use common\models\User;
use yii\helpers\ArrayHelper;

/**
 * Driver Map Controller
 *
 * @author -xXLXx-
 */
class TrackingController extends BaseController
{
    /**
     * Map
     */
    public function actionIndex()
    {
        $storeOwner = \Yii::$app->user->identity->storeOwner;
        $currentStore = $storeOwner->storeCurrent;
        $store = [
            'id' => $currentStore->id,
            'position' => [$currentStore->address->latitude, $currentStore->address->longitude]
        ];

        $drivers = User::find()
            ->innerJoinWith(['acceptedShifts'])
            ->andWhere([
                'storeId'   => $currentStore->id,
                'actualEnd' => null
            ])
            ->all();
        $drivers = ArrayHelper::toArray($drivers);

        return $this->render('index', compact('drivers', 'store'));
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

        if ($driver) {
            $imagePath = \Yii::getAlias('@webroot') . $driver->image->thumbUrl;
        }
        if (!file_exists($imagePath)) {
            $imagePath = \Yii::getAlias('@webroot') . "/img/temp/02.jpg";
        }
        $driverImg = imagecreatefromjpeg($imagePath);

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
}
