<?php
    use frontend\widgets\StoreSwitch\assets\StoreSelectAsset;
    use yii\helpers\Url;
    use yii\helpers\Html;
    StoreSelectAsset::register($this);
    use common\helpers\ArrayHelper;
    
    $storeArrayMap = ArrayHelper::getArrayMap($stores, 'title'); 
?>
    <div class="item">
        <h4><?= \Yii::t('app', 'Store') ?></h4>
        <?= Html::dropDownList('stores', $storeCurrent->id, $storeArrayMap, [
            'id'    => 'switchCurrentStore',
            'class' => 'store-select select-100 j_select'
        ]); ?>
    </div>
<?php
    $url = Url::to(['store-select/index']);
    $this->registerJs("StoreSwitchWidget.init('$url', '$redirectUrl');");
?>