<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model frontend\models\StoreSignupForm
 */
$this->title = \Yii::t('app', 'Store Owner Signup');



$options = ['options'=>['class'=>'']];
$wholerow = ['options'=>['class'=>'']];
?>

       

<h2 class="center">Few steps to start using Yello</h2>

<div class="gray-text center">Lorem ipsum dolor sit amet, consectetur adipscing elit.<br>Maecenas ut tellus est. Donec ut eros magna.
        </div>
<center>
                <div style="max-width:700px;border:1px solid #bcc0c1; border-radius:6px;position:relative;margin-top:30px;text-align: left;">

                    <div class="create-header" style="background:#f6f6f6;">
                        <div class="step-list">
                            <div class="step-item active"><span>1</span>Company Details</div>
                            <div class="step-item"><span>2</span>Payment Details</div>
                            <div class="step-item"><span>3</span>Create first Store</div>
                        </div>
                    </div>
        <?php
            $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'id' => 'store-signup-form',
                'fieldConfig' => [
                    'template' => '<div class="">{label}{input}{error}</div>',
                    'horizontalCssClasses' => [
                        'error' => 'error-message',
                        'label' =>'',
                        'placeholder'=>''
                    ]
                ],
            ]); 
         ?>
         <?= Html::activeHiddenInput($model, 'id'); ?>
                    <div class="create-body">
                        <div class="row" style="margin-top:30px;">
                            <div class="col col-md-6 col-lg-6">
                                <div class="col col-md-10">
                                <h3>Contact Details</h3>
                                <div class="gray-text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut tellus est. Donec ut eros magna.</p></div>
                                </div>
                            </div>
                            <div class="col col-md-6 col-lg-6">
                                <?php echo $form->field($model, 'companyname',$options); ?>
                                <?php echo $form->field($model, 'abn',$options); ?>
                                <?php echo $form->field($model, 'contact_phone',$options); ?>
                                
                                
                                
                            </div>
                        </div>
                    </div>
                    
                    <hr style="width:90%;margin:30px;">

                    <div class="create-body">
                        <div class="row">
                            <div class="col col-md-6 col-lg-6">
                                <div class="col col-md-10">
                                <h3>Address</h3>
                                <div class="gray-text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut tellus est. Donec ut eros magna.</p></div>
                                <div class="error-summary"></div>
                                </div>
                            </div>
                            <div class="col col-md-6 col-lg-6" id="address">
                                    <input class="form-control" id="autocomplete" placeholder="Enter your address here" onfocus="geolocate()" type="text" autocomplete="off">
                                
                                    <?php echo $form->field($model, 'block_or_unit',['options'=>['placeholder'=>'Floor and/or Unit']]); ?>
                                    <?php echo $form->field($model, 'street_number',['options'=>['class'=>'col-sm-3 col-md-3 col-lg-3','style'=>'padding-left:0;padding-right:5px;']]); ?>
                                    <?php echo $form->field($model, 'route',['options'=>['class'=>'col-sm-9 col-md-9 col-lg-9', 'style'=>'padding-left:0;padding-right:0;']]); ?>
                                    <?php echo $form->field($model, 'locality',['options'=>['class'=>'col col-sm-12 col-md-8 col-lg-8','style'=>'padding-left:0;padding-right:5px;']]); ?>
                                    <?php echo $form->field($model, 'administrative_area_level_1',['options'=>['class'=>'col col-sm-6 col-md-4 col-lg-4','style'=>'padding-left:0;padding-right:0px;']]); ?>
                                    <?php echo $form->field($model, 'postal_code',['options'=>['class'=>'col col-sm-6 col-md-4 col-lg-3','style'=>'padding-left:0;padding-right:5px;']]); ?>
                                    <?php echo $form->field($model, 'country',['options'=>['class'=>'col col-sm-6 col-md-8 col-lg-9','style'=>'padding-left:0;padding-right:0px;']]); ?>                               
                            </div>
                        </div>
                    </div>
                                        
                    
                    
                    <div class="create-footer text-right" style="margin-top:30px;">
                        <?= Html::submitButton(\Yii::t('app', 'Next Step'), ['class' => 'btn blue uppercase disableme']); ?>
                    </div>
        <?php ActiveForm::end(); ?>
                </div>      
</center>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
    <script>    
        var formname = 'storesignupform';
        formname = formname+'-';
        var placeSearch, autocomplete;
        var componentForm = {
          subpremise: 'long_name',
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