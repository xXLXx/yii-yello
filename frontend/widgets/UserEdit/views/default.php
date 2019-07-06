<?php
/**
 * @var $user \common\models\User
 * @var $model \frontend\models\UserForm\AbstractForm
 * @var $pageName string
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'layout' => 'horizontal',
    'id' => 'user-edit-form',
    'fieldConfig' => [
        'template' => '{input}{error}',
        'horizontalCssClasses' => [
            'error' => 'error-message'
        ]
    ],
    'options' => ['enctype' => 'multipart/form-data']
]);
echo Html::activeHiddenInput($model, 'id');
echo Html::activeHiddenInput($model, 'roleId');
echo $this->render('blocks/' . $model->getTemplate(), [
    'form' => $form,
    'model' => $model,
    'canSetIsAdmin' => $canSetIsAdmin,
]);
echo $this->render($pageName . '/footer', [
    'form' => $form,
    'model' => $model,
    'canSetIsAdmin' => $canSetIsAdmin,
]);

ActiveForm::end();