
var jsAddressWidget = {

    fieldFormatMapping: AddressWidget.fieldFormatMapping,
    autocomplete: null,

    /**
     * Init
     */
    init: function() {
        // Create the autocomplete object, restricting the search
        // to geographical location types.
        this.autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById(AddressWidget.id)),
            { types: ['geocode'] });
        // When the user selects an address from the dropdown,
        // populate the address fields in the form.
        google.maps.event.addListener(this.autocomplete, 'place_changed', function(){
            jsAddressWidget.fillInAddress();
        });

        this.geolocate();
    },
    // [START region_fillform]
    fillInAddress: function () {
        // Get the place details from the autocomplete object.
        var place = this.autocomplete.getPlace();
        var formName = AddressWidget.formName;
        formName = formName+'-';
        console.log(place);

        // Clear all fields
        for (var component in this.fieldFormatMapping) {
            // console.log(component);
            if(component=='subpremise'){
                document.getElementById(formName+'block_or_unit').value = '';
                // document.getElementById(formName+'block_or_unit').disabled = false;
                
            }else{
                document.getElementById(formName+component).value = '';
                // document.getElementById(formName+component).disabled = false;
                
            }
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (this.fieldFormatMapping[addressType]) {
                var val = place.address_components[i][this.fieldFormatMapping[addressType]];
                if(addressType=='subpremise'){
                    document.getElementById(formName+'block_or_unit').value = val;
            }else{
                    document.getElementById(formName+addressType).value = val;
                }
            }
        }

        if (document.getElementById(formName+'formatted_address')) {
            document.getElementById(formName+'formatted_address').value = place.formatted_address;
        }

        if (document.getElementById(formName+'latitude')) {
            document.getElementById(formName+'latitude').value = place.geometry.location.lat();
        }

        if (document.getElementById(formName+'longitude')) {
            document.getElementById(formName+'longitude').value = place.geometry.location.lng();
        }

        if (document.getElementById(formName+'googleplaceid')) {
            document.getElementById(formName+'googleplaceid').value = place.place_id;
        }

        if (document.getElementById(formName+'googleobj')) {
            document.getElementById(formName+'googleobj').value = JSON.stringify(place);
        }

        // get timezone
        $.get('https://maps.googleapis.com/maps/api/timezone/json', {
            location: place.geometry.location.lat()+','+place.geometry.location.lng(),
            timestamp: Math.floor((new Date()).getTime() / 1000)
        }, function(response){
            document.getElementById(formName+'utcoffset').value = response.rawOffset / 3600;
            document.getElementById(formName+'timezone').value = response.timeZoneId;
        })
    },
    // [END region_fillform]

    // [START region_geolocation]
    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    geolocate: function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = new google.maps.LatLng(
                    position.coords.latitude, position.coords.longitude);
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
               jsAddressWidget.autocomplete.setBounds(circle.getBounds());
            });
        }
    }
    // [END region_geolocation]
};

jsAddressWidget.init();