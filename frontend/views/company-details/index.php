<?php

use frontend\widgets\SettingsLeftNavigation;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model frontend\models\CompanyForm
 */
$this->title = \Yii::t('app', 'Company Details');




$options = ['options'=>['class'=>'col col-sm-11 col-md-5 col-lg-5']];
$wholerow = ['options'=>['class'=>'col col-sm-11 col-md-10 col-lg-10']];
?>

<div class="sidebar-container">
    <?= SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <h2><?= $this->title ?></h2>
        <?php
            $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'id' => 'company-edit-form',
                'fieldConfig' => [
                    'template' => '<div class="">{label}{input}{error}</div>',
                    'horizontalCssClasses' => [
                        'error' => 'error-message',
                        'label' =>''
                    ]
                ],
            ]); 
         ?>
         <?= Html::activeHiddenInput($model, 'id'); ?>

        <div class="row">
        <?php echo $form->field($model, 'accountName',$options); ?>
        <?php echo $form->field($model, 'companyName',$options); ?>
        <?php echo $form->field($model, 'ABN',$options); ?>
        </div>
            
        <div class="row">
        <?php echo $form->field($model, 'contact_name',$options); ?>
        <?php echo $form->field($model, 'contact_phone',$options); ?>
        <?php echo $form->field($model, 'contact_email',$options); ?>
        </div>
        <div class="row">
            <div id="locationField" class="col col-sm-11 col-md-10 col-lg-10">
                <label class="control-label">Address</label><br />
                <input class="form-control" id="autocomplete" placeholder="Enter your address" onfocus="geolocate()" type="text" autocomplete="off">
            </div>
        </div>
        <div class="row" id="address">
            <?php echo $form->field($model, 'street_number',['options'=>['class'=>'col col-sm-3 col-md-2 col-lg-2']]); ?>
            <?php echo $form->field($model, 'route',['options'=>['class'=>'col col-sm-8 col-md-8 col-lg-8']]); ?>
            <?php echo $form->field($model, 'locality',['options'=>['class'=>'col col-sm-7 col-md-5 col-lg-5']]); ?>
            <?php echo $form->field($model, 'administrative_area_level_1',['options'=>['class'=>'col col-sm-4 col-md-3 col-lg-3']]); ?>
            <?php echo $form->field($model, 'postal_code',['options'=>['class'=>'col col-sm-4 col-md-2 col-lg-2']]); ?>
            <?php echo $form->field($model, 'country',['options'=>['class'=>'col col-sm-7 col-md-10 col-lg-10']]); ?>
            <div class="clearfix"></div>
            
            
        </div>
        
        <div class="border-top-block col col-lg-10">
                <?= Html::submitButton(\Yii::t('app', 'Save Settings'), ['class' => 'btn blue']); ?>
            </div>
            

        <?php ActiveForm::end(); ?>
    </div>
</div>


<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
    <script>    
        var formname = 'companyform';
        formname = formname+'-';
        var placeSearch, autocomplete;
        var componentForm = {
          street_number: 'short_name',
          route: 'long_name',
          locality: 'long_name',
          administrative_area_level_1: 'short_name',
          country: 'long_name',
          postal_code: 'short_name'
        };

        function initialize() {
          // Create the autocomplete object, restricting the search
          // to geographical location types.
          autocomplete = new google.maps.places.Autocomplete(
              /** @type {HTMLInputElement} */(document.getElementById('autocomplete')),
              { types: ['geocode'] });
          // When the user selects an address from the dropdown,
          // populate the address fields in the form.
          google.maps.event.addListener(autocomplete, 'place_changed', function() {
            fillInAddress();
          });
        }

        // [START region_fillform]
        function fillInAddress() {
          // Get the place details from the autocomplete object.
          var place = autocomplete.getPlace();

          for (var component in componentForm) {
            document.getElementById(formname+component).value = '';
            document.getElementById(formname+component).disabled = false;
          }

          // Get each component of the address from the place details
          // and fill the corresponding field on the form.
          for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
              var val = place.address_components[i][componentForm[addressType]];
              document.getElementById(formname+addressType).value = val;
            }
          }
        }
        // [END region_fillform]

        // [START region_geolocation]
        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              var geolocation = new google.maps.LatLng(
                  position.coords.latitude, position.coords.longitude);
              var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
              });
              autocomplete.setBounds(circle.getBounds());
            });
          }
        }
        // [END region_geolocation]    

    
    
    
    // this is a quick layout fix. TODO: lalit
    window.onload = function(){
        initialize();
        
        //TODO: Jovani - please fix layout gap,
        // - move address functionality to widget 
        // - add latitude longitude population from form
        // - see controller for update functions
        
     $("div .form-group").each(function(){$(this).addClass('col col-sm-11 col-md-5');});
 }
    </script>