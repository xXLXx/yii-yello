<?php

use common\helpers\ArrayHelper;
use frontend\models\UserForm\CommonManagerForm;
use frontend\models\UserForm\FranchiserForm;
use frontend\models\UserForm\ManagerForm;
use frontend\models\UserForm\MenuAggregatorForm;
use frontend\models\UserForm\StoreOwnerForm;
use frontend\models\UserForm\YelloAdminForm;
use yii\helpers\Html;

/** @var \frontend\models\UserForm\StoresAwareUserForm $model */

?>
<div class="clearfix">
    <table class="profile-settings f-left">
        <tr>
            <td>
                <label for="userName"><?= \Yii::t('app', 'First Name'); ?></label>
                <?= 
                    Html::activeTextInput($model, 'firstName', [
                        'class' => 'text-input',
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
                        'class' => 'text-input',
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
                            <?php $counter++; ?>
                            <?php if ($counter%3 == 0): ?></div><?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </td>
        </tr>

        <tr>
            <td>
                <label for="pass"><?= \Yii::t('app', 'Password') ?></label>
                <?= 
                    Html::activePasswordInput($model, 'password', [
                        'class' => 'text-input',
                        'id'    => 'pass'
                    ]);
                ?>
                <?= Html::error($model, 'password', ['class' => 'error-message']) ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="confirm"><?= \Yii::t('app', 'Repeat Password') ?></label>
                <?= 
                    Html::activePasswordInput($model, 'confirm', [
                        'class' => 'text-input',
                        'id'    => 'confirm'
                    ]);
                ?>
                <?= Html::error($model, 'confirm', ['class' => 'error-message']) ?>
            </td>
        </tr>
<!--        <tr>
            <td>
                <div class="checkbox-input">
                    <input type="checkbox" checked="checked" value="" id="agreement">
                    <label for="agreement" class="j_checkbox active">This user has Admin privileges</label>
                </div>
            </td>
        </tr>-->
    </table>
    <div class="profile-user-photo">
        <div class="user-photo-container">
            <img class="j_image-file-destination" src="<?= $model->image ? $model->image->thumbUrl : '/img/driver_head.svg'?>" alt="John" />
        </div>
        <div class="upload-file">
            <div class="icon-link font-picture-streamline blue-text">Upload new photo</div>
            <?=
                Html::activeFileInput($model, 'imageFile', [
                    'class' => 'j_image-file-input',
                    'id'    => 'image'
                ]);
            ?>
<!--            <input class="j_image-file-input" type="file" size="1"/>-->
        </div>
        <a class="icon-link font-delete-garbage-streamline red-text" href="#">Delete</a>
    </div>
</div>
<?php if ($model instanceof ManagerForm || $model instanceof YelloAdminForm || $model instanceof CommonManagerForm): ?>
<div class="checkbox-input js-admin-priv-container <?php if (!(($model instanceof ManagerForm || $model instanceof YelloAdminForm || $model instanceof CommonManagerForm) && $canSetIsAdmin)): ?> hide<?php endif; ?>">
    <?= Html::checkbox($model->formName() . '[isAdmin]', $model->isAdmin, ['id' => 'is-admin']) ?>
    <label for="is-admin" class="j_checkbox <?php if ($model->isAdmin): ?>active<?php endif; ?>">
        <?= \Yii::t('app', 'This user has Admin privileges'); ?>
    </label>
</div>
<?php endif; ?>