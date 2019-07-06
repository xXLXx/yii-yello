<?php

namespace common\helpers;

class ImageResizeHelper
{
    public function resizeImage($input)
    {

    }

    /**
     * Resize an image file according to specified sizes.
     *
     * @param string $sourceFile path to the source file
     * @param array $sizes key must be the size with destination file path as the value
     *         ['original' => '/var/www/uploads/lol.png', '100' => ... ]
     */
    public static function resizeAndUpload($sourceFile, $sizes)
    {
        $results = [];
        foreach ($sizes as $size => $destinationFile) {
            $url = '';
            try {
                if ($size == 'original') {
                    $url = \Yii::$app->storage->uploadFile($sourceFile, $destinationFile);
                } else {
                    $temporaryFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid($size, true).'.png';
                    $image = \yii\imagine\Image::getImagine()->open($sourceFile);

                    // Only jpegs have exif data
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_file($finfo, $sourceFile);
                    finfo_close($finfo);
                    if ($mimeType == 'image/jpg' || $mimeType == 'image/jpeg') {
                        $exif = exif_read_data($sourceFile);
                        switch ($exif['Orientation']) {
                            case 6:
                                $image->rotate(90);
                                break;

                            case 8:
                                $image->rotate(-90);
                                break;
                        }
                    }
                    $image->resize($image->getSize()->widen($size));
                    $image->save($temporaryFile, ['quality' => 50]);

                    $url = \Yii::$app->storage->uploadFile($temporaryFile, $destinationFile);
                }
            } catch (\Exception $e) {
                \Yii::error($e->getMessage());
                continue;
            }

            $results[$size] = $url;
        }

        return $results;
    }
}