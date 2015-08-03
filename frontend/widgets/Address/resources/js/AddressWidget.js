var jsAddressWidget = {

    componentForm: AddressWidget.fieldsMapping,
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

        var formname = AddressWidget.formName;
        formname = formname+'-';

        for (var component in this.componentForm) {
            document.getElementById(formname+component).value = '';
            document.getElementById(formname+component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (this.componentForm[addressType]) {
                var val = place.address_components[i][this.componentForm[addressType]];
                document.getElementById(formname+addressType).value = val;
            }
        }

        if (document.getElementById(formname+'latitude')) {
            document.getElementById(formname+'latitude').value = place.geometry.location.lat();
        }

        if (document.getElementById(formname+'longitude')) {
            document.getElementById(formname+'longitude').value = place.geometry.location.lng();
        }
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