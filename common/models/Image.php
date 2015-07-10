<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
/**
 * This is the model class for table "Image".
 *
 * @property integer $id
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
 * @property string $originalUrl
 * @property string $largeUrl
 * @property string $thumbUrl
 * @property string $title
 * @property string $alt
 */
class Image extends \common\models\BaseModel
{
    /**
     * Image file
     *
     * @var \yii\web\UploadedFile
     */
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Image';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'isArchived' => Yii::t('app', 'Is Archived'),
            'originalUrl' => Yii::t('app', 'Original Url'),
            'largeUrl' => Yii::t('app', 'Large Url'),
            'thumbUrl' => Yii::t('app', 'Thumb Url'),
            'title' => Yii::t('app', 'Title'),
            'alt' => Yii::t('app', 'Alt'),
        ];
    }

    public function saveFiles()
    {
        $webPath = Yii::$app->basePath . '/web';

        $imageDir = $webPath . '/upload/images/';
        if ( ! file_exists($imageDir) ) {
            FileHelper::createDirectory($imageDir);
        }

        $originalUrl = '/upload/images/' . $this->id . '.'
            . $this->imageFile->getExtension();
        $originalOutput =  $webPath . $originalUrl;
        $thumbUrl = '/upload/images/' . $this->id . '-thumb.'
            . $this->imageFile->getExtension();
        $thumbOutput = $webPath . $thumbUrl;
        $this->imageFile->saveAs($originalOutput);
        \yii\imagine\Image::thumbnail($originalOutput, 144, 144)->save($thumbOutput);
        $this->originalUrl = $originalUrl;
        $this->thumbUrl = $thumbUrl;
        return true;
    }
}
