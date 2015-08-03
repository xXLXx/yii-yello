    /*====================================================
     * 
     *                    STRIPE
     * 
     ====================================================*/
    
    
    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('pk_test_A5CgozV4pTjiPgGHGopDZKIw');
    // ...

        var stripeResponseHandler = function(status, response) {
          var $form = $('#store-signup-step-two');
          

          if (response.error) {
            // Show the errors on the form
            $form.find('.payment-errors').text(response.error.message);
            $form.find('button').prop('disabled', false).enableButton();
          } else {
            // token contains id, last4, and card type
            var token = response.id;
            // Insert the token into the form so it gets submitted to the server
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));
            // and submit
            alert(token);
                $form.get(0).submit();
          }
        };


        jQuery(function ($) {
            $('#store-signup-step-two').submit(function (event) {
                var $form = $(this);
                // Disable the submit button to prevent repeated clicks
                $form.find('button').prop('disabled', true);
                Stripe.card.createToken($form, stripeResponseHandler);
                // Prevent the form from submitting with the default action
                return false;
            });
        });


    /*====================================================
     * 
     *                    GOOGLE MAPS
     * 
     ====================================================*/
        var formname = 'store-signup-step-two';
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
          console.log(place);
          var stripes = $(document).find(".stripeform");
          var addressline1 = '';
          var unit='';
          var streetnumber='';
          var route='';
          $(stripes).each(function(s){
              $(this).val('');
              $(this).attr('disabled',false);
          });

          // Get each component of the address from the place details
          // and fill the corresponding field on the form.
          for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
              var val = place.address_components[i][componentForm[addressType]];
              switch(addressType){
                  case 'street_number':
                      streetnumber = val;
                      break;
                  case 'subpremise':
                      unit=val;
                      break;
                  case 'route':
                      route=val;
                      break;
                  case 'administrative_area_level_1':
                      popstripe('address_state',val);
                      break;
                  case 'locality':
                      popstripe('address_city',val);
                      break;
                  case 'postal_code':
                      popstripe('address_zip',val);
                      break;
                  case 'country':
                      popstripe('address_country',val);
                      break;
              }


            }
          }
          addressline1 = streetnumber+' '+route;
          if(unit.length>0){
              addressline1 = unit+'/'+addressline1;
          }
          //SignupStorePaymentDetails[address_line1]
          popstripe('address_line1',addressline1);
          
        }
        // [END region_fillform]

        // [START region_geolocation]
        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocatestripe() {
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

        function popstripe(fname,fdata){
           var stripes =$(document).find(".stripeform");
           $(stripes).each(function(){
               if($(this).data('stripe')==fname){
                   $(this).val(fdata);
               }
           });
        }
    
    
    // this is a quick layout fix. TODO: lalit
    window.onload = function(){
        initialize();
        
        //TODO: Jovani - please fix layout gap,
        // - move address functionality to widget 
        // - add latitude longitude population from form
        // - see controller for update functions
        
 }
    