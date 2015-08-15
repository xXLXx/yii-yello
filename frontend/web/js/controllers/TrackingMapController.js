/**
 * Controller tracking map page
 *
 * @author -xXLXx-
 */

var TrackingMapController = {

    data: {
        mapOptions: {
            zoom: 12
        },
        selector: '#map-canvas',
        store: {
            id: -1,
            position: [0, 0]
        },
        drivers: [],
        inactiveDriverTimeout: 30000
    },

    map: null,

    pubnub: null,

    // drivers that are currently on the map
    mapDrivers: [],

    /**
     * Init
     */
    init: function(data) {
        var context = this;
        context.data = $.extend({}, context.data, data);

        google.maps.event.addDomListener(window, 'load', function () {
            var storeLocation = new google.maps.LatLng(context.data.store.position[0], context.data.store.position[1]);
            context.map = new google.maps.Map($(context.data.selector)[0], $.extend({center: storeLocation}, context.data.mapOptions));

            // Never mind presence for now, will be used in the future
            //
            // setInterval(function () {
            //     context.initActiveDrivers();
            // }, 30000);
            context.initActiveDrivers();

            setInterval(function () {
                context.clearInactiveDrivers();
            }, context.data.inactiveDriverTimeout);

            // Add store marker
            new google.maps.Marker({
                position: storeLocation,
                map: context.map,
                strokeOpacity: 0,
                icon: {
                    url: document.location.protocol + '//' + document.location.hostname + '/img/marker-store.png',
                    scaledSize: new google.maps.Size(40, 40)
                },
                optimized: false
            });
        });

        context.pubnub = PUBNUB({
            publish_key   : 'pub-c-811c6537-1862-4b4c-9dac-13220db0928d',
            subscribe_key : 'sub-c-ac40e412-23b2-11e5-8ae2-0619f8945a4f',
            ssl: ((document.location.protocol == 'https:') ? true : false)
        });
    },

    /**
     * Move map to store location
     */
    panToStoreLocation: function () {
        this.map.panTo(new google.maps.LatLng(this.data.store.position[0], this.data.store.position[1]));
        this.map.setZoom(this.data.mapOptions.zoom);
    },

    /**
     * Clear inacive markers from map
     */
    clearInactiveDrivers: function () {
        var context = this;
        $.each(context.mapDrivers, function (key, value) {
            var now = new Date();
            if (value.marker && now - value.lastUpdate > context.data.inactiveDriverTimeout) {
                value.state = null;
                value.marker.setMap(null);
                value.marker = null;
            }
        });
    },

    /**
     * Initialize all currently active drivers to the map
     */
    initActiveDrivers: function () {
        var context = this;
        // Never mind presence for now, will be used in the future
        //
        // context.pubnub.here_now({
        //     channel: 'store_' + context.data.storeId,
        //     state: true,
        //     callback: function(m){
        //         console.log(m);

        //         // Clear all mapdriver makers and array
        //         $.each(context.mapDrivers, function (key, value) {
        //             value.marker.setMap(null);
        //             // unsubscribe to this driver's channel
        //             pubnub.unsubscribe(value.state.channel);
        //         });
        //         context.mapDrivers = [];

        //         // Add all active drivers to map
        //         $.each(m.uuids, function (key, value) {
        //             if (value.state) {
        //                 if (value.state.lat && value.state.lng) {
        //                     var mapDriversCurrentIdx = context.mapDrivers.length;
        //                     context.mapDrivers.push({
        //                         state: value.state,
        //                         marker: new google.maps.Marker({
        //                             position: new google.maps.LatLng(value.state.lat, value.state.lng),
        //                             map: context.map
        //                         }),
        //                         pubnubCallback: function (m) {
        //                             context.mapDrivers[mapDriversCurrentIdx].state = m;
        //                             context.mapDrivers[mapDriversCurrentIdx].marker.setPosition(new google.maps.LatLng(m.lat, m.lng));
        //                         }
        //                     });

        //                     // Subscribe to this driver's channel
        //                     console.log(context.mapDrivers[mapDriversCurrentIdx]);
        //                     pubnub.subscribe({
        //                         channel : context.mapDrivers[mapDriversCurrentIdx].state.channel,
        //                         message : context.mapDrivers[mapDriversCurrentIdx].pubnubCallback,
        //                     });
        //                 }
        //             }
        //         });
        //     }
        // });

        $.each(context.data.drivers, function (key, value) {
            var mapDriversCurrentIdx = context.mapDrivers.length;
            context.mapDrivers.push({
                pubnubCallback: function (m) {
                    context.mapDrivers[mapDriversCurrentIdx].driver = value;
                    context.mapDrivers[mapDriversCurrentIdx].state = m;
                    context.mapDrivers[mapDriversCurrentIdx].lastUpdate = new Date();
                    var position = new google.maps.LatLng(m.lat, m.lng);
                    if (context.mapDrivers[mapDriversCurrentIdx].marker) {
                        context.mapDrivers[mapDriversCurrentIdx].marker.setPosition(position);
                    } else {
                        context.mapDrivers[mapDriversCurrentIdx].marker = new google.maps.Marker({
                            position: position,
                            map: context.map,
                            icon: {
                                url: document.location.protocol + '//' + document.location.hostname + '/tracking/get-driver-marker?driverId=' + value.id,
                                scaledSize: new google.maps.Size(45, 50)
                            },
                            optimized: false
                        });
                    }

                    console.log('driver_' + context.mapDrivers[mapDriversCurrentIdx].driver.id);
                    console.log(m);
                }
            });
            context.pubnub.subscribe({
                channel : 'driver_' + value.id,
                message : context.mapDrivers[mapDriversCurrentIdx].pubnubCallback,
            });
        });
    }
};
