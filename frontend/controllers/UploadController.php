<?php
namespace frontend\controllers;

use app\models\ImageUploadForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * File Upload controller
 */
class UploadController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'image'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@','?'],
                    ],[
                        'actions' => ['image'],
                        'allow' => true,
                        'roles' => ['@','?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'image'  => ['post'],
                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
    }

    public function actionImage()
    {
        $success = false;
        $imageUploadModel = new ImageUploadForm();
        $imageUploadModel->file = UploadedFile::getInstance($imageUploadModel, 'file');
        if ($imageUploadModel->file) {
            $success = true;//Yii::$app->request->post();
        }
        $data = ['success' => $success];

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
        $data = json_decode(Yii::$app->request->get('files'), true);

    }
}