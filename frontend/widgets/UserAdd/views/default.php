<?php

use frontend\models\UserForm\UserAddForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\widgets\UserAdd\assets\UserAddAsset;

UserAddAsset::register($this);

/** @var UserAddForm $model */

?>

<?php
    $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'id' => 'user-add-form',
        'fieldConfig' => [
            'template' => '{input}{error}',
            'horizontalCssClasses' => [
                'error' => 'error-message'
            ]
        ],
        'options' => ['enctype' => 'multipart/form-data']
    ]); 
?>
    <div class="clearfix">
        <table class="profile-settings f-left">
            <tbody>
                <tr>
                    <td>
                        <label for="userName"><?= \Yii::t('app', 'First Name'); ?></label>
                        <?= 
                            Html::activeTextInput($model, 'firstName', [
                                'class' => 'text-input small',
                                'id' => 'userName'
                            ]);
                        ?>
                        <?= Html::error($model, 'firstName', ['class' => 'error-message']) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="userLastName"><?= \Yii::t('app', 'Last Name') ?></label>
                        <?= 
                            Html::activeTextInput($model, 'lastName', [
                                'class' => 'text-input small',
                                'id' => 'userLastName'
                            ]);
                        ?>
                        <?= Html::error($model, 'lastName', ['class' => 'error-message']) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email"><?= \Yii::t('app', 'Email'); ?></label>
                        <?= 
                            Html::activeTextInput($model, 'email', [
                                'class' => 'text-input',
                                'id'    => 'email'
                            ]);
                        ?>
                        <?= Html::error($model, 'email', ['class' => 'error-message']) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="userRole">Role</label>
                        <?= 
                            Html::activeDropDownList($model, 'roleId', $model->getRoleArrayMap(), [
                                'class' => 'select-218 j_select'
                            ]); 
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="stores"><?= \Yii::t('app', 'Stores'); ?></label>
                        <?php if ($model->getStoresArrayMap()): ?>
                            <div class="table-block">
                                <?php $counter = 0; ?>
                                <?php foreach ($model->getStoresArrayMap() as $id => $store): /** @var \common\models\Store $store */ ?>
                                    <?php if ($counter%3 == 0): ?><div class="table-cell-item"><?php endif; ?>
                                    <div class="checkbox-input">
                                        <input type="checkbox" id="stores<?= $id ?>" value="<?= $id ?>" <?php if ($model->hasUserStoreRelation($id)): ?>checked="checked"<?php endif; ?> name="<?= $model->formName() ?>[stores][]">
                                        <label for="stores<?= $id ?>" class="j_checkbox <?php if ($model->hasUserStoreRelation($id)): ?>active<?php endif; ?>"><?= $store ?></label>
                                    </div>
                                    <?php $counter++ ?>
                                    <?php if ($counter%3 == 0): ?></div><?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
<!--                <tr>
                    <td>
                        <label for="userUserName">Username</label>
                        <input type="text" class="text-input small" id="userUserName">
                    </td>
                </tr>-->
                <tr>
                    <td>
                        <label for="userPass"><?= \Yii::t('app', 'Password') ?></label>
                        <?= 
                            Html::activePasswordInput($model, 'password', [
                                'class' => 'text-input',
                                'id'    => 'userPass'
                            ]);
                        ?>
                        <?= Html::error($model, 'password', ['class' => 'error-message']) ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="profile-user-photo">
            <div class="user-photo-container no-photo">
                <?php if ($model->image): ?>
                    <img src="<?= $model->image->thumbUrl ?>" class="j_image-file-destination">
                <?php else: ?>
                    <img class="j_image-file-destination hide">
                <?php endif; ?>
            </div>
            <div class="upload-file">
                <div class="link-icon font-picture-streamline blue-text"><?= \Yii::t('app', 'Add profile photo'); ?></div>
                <?=
                    Html::activeFileInput($model, 'imageFile', [
                        'class' => 'j_image-file-input',
                        'id'    => 'image'
                    ]);
                ?>
            </div>
        </div>
    </div>
    <?php if ($canSetIsAdmin): ?>
        <div class="checkbox-input js-admin-priv-container <?php if (!$model->isManager()): ?> hide<?php endif; ?>">
            <?= Html::checkbox($model->formName() . '[isAdmin]', $model->isAdmin, ['id' => 'is-admin']) ?>
            <label for="is-admin" class="j_checkbox <?php if ($model->isAdmin): ?>active<?php endif; ?>">
                <?= \Yii::t('app', 'This user has Admin privileges'); ?>
            </label>
        </div>
        <br>
        <p class="text-icon font-exclamation-triangle gray-text icon-orange">
            <?= \Yii::t('app', 'Admins have full access to user management, import/export, upgrade, and apply account customizations.'); ?>
        </p>
    <?php endif; ?>
    <div class="border-top-block">
        <?= Html::resetButton(\Yii::t('app', 'Cancel'), ['class' => 'btn']); ?>
        <?= Html::submitButton(\Yii::t('app', 'Add user'), ['class' => 'btn blue']); ?>
    </div>
<?php ActiveForm::end(); ?>

<?php
    $this->registerJs('ImageUploadPreview.init();');
    $this->registerJs("UserAddWidget.init($json);");
?>