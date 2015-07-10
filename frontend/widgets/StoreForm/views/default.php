<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->registerJs('ImageUploadPreview.init();');
?>
<?php
    $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'id' => 'store-form',
        'fieldConfig' => [
            'template' => '{input}{error}',
            'horizontalCssClasses' => [
                'error' => 'error-message'
            ]
        ],
        'options' => ['enctype' => 'multipart/form-data']
    ]);
?>
<?= Html::activeHiddenInput($model, 'id'); ?>
    <table class="profile-settings">
        <tbody>
        <tr>
            <td>
                <label for="storeName"><?= \Yii::t('app', 'Store Name'); ?></label>
                <?=
                Html::activeTextInput($model, 'title', [
                    'class' => 'text-input small',
                    'id' => 'storeName'
                ]);
                ?>
                <?= Html::error($model, 'storeName', ['class' => 'error-message']) ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="address1"><?= \Yii::t('app', 'Address'); ?><span class="gray-text"> (<?= \Yii::t('app', 'Line'); ?> 1)</span></label>
                <?=
                Html::activeTextInput($model, 'address1', [
                    'class' => 'text-input small',
                    'id' => 'address1'
                ]);
                ?>
                <?= Html::error($model, 'address1', ['class' => 'error-message']) ?>
            </td>
            <td>
                <label for="adddress2"><?= \Yii::t('app', 'Address'); ?><span class="gray-text"> (<?= \Yii::t('app', 'Line'); ?> 2)</span></label>
                <?=
                Html::activeTextInput($model, 'address2', [
                    'class' => 'text-input small',
                    'id' => 'address2'
                ]);
                ?>
                <?= Html::error($model, 'address2', ['class' => 'error-message']) ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="suburb"><?= \Yii::t('app', 'Suburb'); ?></label>
                <?=
                Html::activeTextInput($model, 'suburb', [
                    'class' => 'text-input small',
                    'id' => 'suburb'
                ]);
                ?>
                <?= Html::error($model, 'suburb', ['class' => 'error-message']) ?>
            </td>
            <td>
                <label for="stateId"><?= \Yii::t('app', 'State'); ?></label>
                <?=
                Html::activeDropDownList($model, 'stateId', $model->getStateArrayMap(), [
                    'id' => 'stateId',
                    'class' => 'j_select select-218'
                ]);
                ?>
                <?= Html::error($model, 'stateId', ['class' => 'error-message']) ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="contactPerson"><?= \Yii::t('app', 'Contact person'); ?></label>
                <?=
                Html::activeTextInput($model, 'contactPerson', [
                    'class' => 'text-input small',
                    'id' => 'contactPerson'
                ]);
                ?>
                <?= Html::error($model, 'contactPerson', ['class' => 'error-message']) ?>
            </td>
            <td>
                <label for="phone"><?= \Yii::t('app', 'Phone'); ?></label>
                <?=
                Html::activeTextInput($model, 'phone', [
                    'class' => 'text-input small',
                    'id' => 'phone'
                ]);
                ?>
                <?= Html::error($model, 'phone', ['class' => 'error-message']) ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="businessTypeId"><?= \Yii::t('app', 'Business type'); ?></label>
                <?=
                Html::activeDropDownList($model, 'businessTypeId', $model->getBusinessTypeArrayMap(), [
                    'id' => 'businessTypeId',
                    'class' => 'j_select select-218'
                ]);
                ?>
                <?= Html::error($model, 'businessTypeId', ['class' => 'error-message']) ?>
            </td>
            <td>
                <label for="abn"><?= \Yii::t('app', 'ABN'); ?></label>
                <?=
                Html::activeTextInput($model, 'abn', [
                    'class' => 'text-input small',
                    'id' => 'abn'
                ]);
                ?>
                <?= Html::error($model, 'abn', ['class' => 'error-message']) ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="website"><?= \Yii::t('app', 'Website'); ?></label>
                <?=
                Html::activeTextInput($model, 'website', [
                    'class' => 'text-input small',
                    'id' => 'website'
                ]);
                ?>
                <?= Html::error($model, 'website', ['class' => 'error-message']) ?>
            </td>
            <td>
                <label for="email"><?= \Yii::t('app', 'Email'); ?></label>
                <?=
                Html::activeTextInput($model, 'email', [
                    'class' => 'text-input small',
                    'id' => 'email'
                ]);
                ?>
                <?= Html::error($model, 'email', ['class' => 'error-message']) ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="businessHours"><?= \Yii::t('app', 'Business Hours'); ?></label>
                <?=
                Html::activeTextarea($model, 'businessHours', [
                    'class' => 'text-input small',
                    'id' => 'businessHours'
                ]);
                ?>
                <?= Html::error($model, 'businessHours', ['class' => 'error-message']) ?>
            </td>
            <td>
                <label for="storeProfile"><?= \Yii::t('app', 'Store Profile'); ?></label>
                <?=
                Html::activeTextarea($model, 'storeProfile', [
                    'class' => 'text-input small',
                    'id' => 'storeProfile'
                ]);
                ?>
                <?= Html::error($model, 'storeProfile', ['class' => 'error-message']) ?>
            </td>
        </tr>
        </tbody>
    </table>
<div class="profile-user-photo" style="">
    <div class="user-photo-container">
        <img class="j_image-file-destination" src="<?= $model->image ? $model->image->thumbUrl : '/img/temp/07.png' ?>"/>
    </div>
    <div class="upload-file">
        <div class="blue-text">Upload logo</div>
        <?=
        Html::activeFileInput($model, 'imageFile', [
            'class' => 'j_image-file-input',
            'id'    => 'image'
        ]);
        ?>
    </div>
</div>
<div class="border-top-block">
    <?= Html::a(\Yii::t('app', 'Cancel'), ['your-stores/index'], ['class' => 'btn white'])?>
    <?php $submitName = $model->id ? \Yii::t('app', 'Edit Store') : \Yii::t('app', 'Add Store');?>
    <?= Html::submitButton($submitName, ['class' => 'btn blue']); ?>
</div>
<?php ActiveForm::end(); ?>