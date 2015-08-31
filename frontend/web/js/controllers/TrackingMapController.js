/**
 * Controller tracking map page
 *
 * @author -xXLXx-
 */

var TrackingMapController = {

    data: {
        mapOptions: {
            zoom: 12,
            fitMaxZoom: 15,
            streetViewControl: false
        },
        selector: '#map-canvas',
        store: {
            id: -1,
            position: [0, 0]
        },
        drivers: [],
        inactiveDriverTimeout: 30000,
        markerAnimation: {
            speed: 50,
            delay: 50,
            enabled: true
        }
    },

    map: null,

    pubnub: null,

    // drivers that are currently on the map
    mapDrivers: [],

    driverChannelPrefix: 'driver_',

    driverCount: 0,

    mapBoundsChanged: false,

    markerClusterer: null,

    /**
    * Count of number of history callbacks already finished
    */
    historyCallbacksLoaded: 0,

    /**
     * Init
     */
    init: function(data) {
        var context = this;
        context.data = $.extend({}, context.data, data);

        google.maps.event.addDomListener(window, 'load', function () {
            var storeLocation = new google.maps.LatLng(context.data.store.position[0], context.data.store.position[1]);
            context.map = new google.maps.Map($(context.data.selector)[0], $.extend({center: storeLocation}, context.data.mapOptions));

            context.markerClusterer = new MarkerClusterer(context.map, [], {
                'imagePath': document.location.protocol + '//' + document.location.hostname + '/img/cluster_marker',
            });

            google.maps.event.addListenerOnce(context.map, 'mouseover', function () {
                google.maps.event.addListenerOnce(context.map, 'bounds_changed', function () {
                    context.mapBoundsChanged = true;
                });
            });

            // Never mind presence for now, will be used in the future
            //
            // setInterval(function () {
            //     context.initActiveDrivers();
            // }, 30000);
            context.initActiveDrivers();

            // Dont call this for now. We'll be listening to 'stillClockedOn' (string) field sent by app
            // setInterval(function () {
            //     context.clearInactiveDrivers();
            // }, context.data.inactiveDriverTimeout);

            // Add store marker
            new google.maps.Marker({
                position: storeLocation,
                map: context.map,
                strokeOpacity: 0,
                icon: {
                    url: document.location.protocol + '//' + document.location.hostname + '/img/marker-store.png',
                    scaledSize: new google.maps.Size(40, 40)
                },
                zIndex: Number.MAX_SAFE_INTEGER,
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
                context.updateDriverCount(-1);
                context.markerClusterer.removeMarker(value.marker);
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
                    // Check if marker is on shift on current store
                    if (Number(m.store_id) == context.data.store.id) {
                        if (context.mapDrivers[mapDriversCurrentIdx].marker) {
                            context.animateMarker(context.mapDrivers[mapDriversCurrentIdx].marker, [[m.lat, m.lng]]);
                        } else {
                            context.mapDrivers[mapDriversCurrentIdx].marker = context.createDriverMarker(position, value.id);
                        }
                    } else {
                        if (context.mapDrivers[mapDriversCurrentIdx].marker) {
                            context.mapDrivers[mapDriversCurrentIdx].marker.setMap(null);
                            context.mapDrivers[mapDriversCurrentIdx].marker = null;
                            context.updateDriverCount(-1);
                            context.markerClusterer.removeMarker(context.mapDrivers[mapDriversCurrentIdx].marker);
                        }
                    }

                    console.log(context.driverChannelPrefix + context.mapDrivers[mapDriversCurrentIdx].driver.id);
                    console.log(m);
                },
                historyCallback: function (m) {
                    console.log(m);
                    if (!context.mapDrivers[mapDriversCurrentIdx].marker) {
                        if (m[0].length) {
                            // if last store_id is not equal to current store id, it means he ended shift or shifted for other companies
                            if (Number(m[0][0].store_id) == context.data.store.id) {
                                var position = new google.maps.LatLng(m[0][0].lat, m[0][0].lng);
                                context.mapDrivers[mapDriversCurrentIdx].marker = context.createDriverMarker(position, value.id);
                            }
                        } else {
                            // Place marker on store's location (default) this means channel has no history
                            // context.mapDrivers[mapDriversCurrentIdx].marker = context.createDriverMarker(
                            //     new google.maps.LatLng(context.data.store.position[0], context.data.store.position[1]),
                            //     value.id
                            // );
                            // context.zoomFitMapMarkers();
                        }
                    }
                    if (++context.historyCallbacksLoaded >= context.mapDrivers.length) {
                        context.zoomFitMapMarkers();
                    }
                }
            });
            context.pubnub.subscribe({
                channel : context.driverChannelPrefix + value.id,
                message : context.mapDrivers[mapDriversCurrentIdx].pubnubCallback,
            });
            context.pubnub.history({
                channel: context.driverChannelPrefix + value.id,
                callback: context.mapDrivers[mapDriversCurrentIdx].historyCallback,
                count: 1,
            });
        });
    },

    /**
     * Creates a driver marker instance from position and driverId
     *
     * @return google.maps.Marker marker
     */
    createDriverMarker: function (position, driverId) {
        var context = this;
        context.updateDriverCount(1);
        var marker = new google.maps.Marker({
            position: position,
            map: context.map,
            icon: {
                url: document.location.protocol + '//' + document.location.hostname + '/tracking/get-driver-marker?driverId=' + driverId,
                scaledSize: new google.maps.Size(45, 50)
            },
            optimized: false
        });

        context.markerClusterer.addMarker(marker);

        return marker;
    },

    /**
     * Updates #drivers-count from this.driverCount by value
     *
     * @params value the number to add
     */
    updateDriverCount: function (value) {
        this.driverCount += value;
        $('.drivers-count').html(this.driverCount);
    },

    /**
     * Animates a marker
     */
    animateMarker: function (marker, coords) {
        var context = this;
        var target = 0;

        if (!context.data.markerAnimation.enabled) {
            marker.setPosition(new google.maps.LatLng(coords[target][0], coords[target][1]));
            return;
        }

        var km_h = context.data.markerAnimation.speed;
        var delay = context.data.markerAnimation.delay;
        
        function goToPoint() {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();

            var step = (km_h * 1000 * delay) / 3600000; // in meters
            
            var dest = new google.maps.LatLng(coords[target][0], coords[target][1]);
            
            var distance =  google.maps.geometry.spherical.computeDistanceBetween(dest, marker.position); // in meters
            
            var numStep = distance / step;
            var i = 0;
            var deltaLat = (coords[target][0] - lat) / numStep;
            var deltaLng = (coords[target][1] - lng) / numStep;
            
            function moveMarker() {
                lat += deltaLat;
                lng += deltaLng;
                i += step;
                
                if (i < distance) {
                    marker.setPosition(new google.maps.LatLng(lat, lng));
                    setTimeout(moveMarker, delay);
                }
                else {
                    marker.setPosition(dest);
                    target++;
                    if (target == coords.length){ return; }
                    
                    setTimeout(goToPoint, delay);
                }
            }
            moveMarker();
        }
        goToPoint();
    },

    /**
     * Zoom map to fit all markers
     */
    zoomFitMapMarkers: function () {
        var context = this;
        if (!context.mapBoundsChanged) {
            var bounds = new google.maps.LatLngBounds();
            $.each(context.mapDrivers, function (key, value) {
                if (value.marker) {
                    bounds.extend(value.marker.getPosition());
                }
            });
            // Limit zoom to not go too deep
            google.maps.event.addListenerOnce(context.map, 'bounds_changed', function(event) {
                context.map.setZoom(Math.min(context.data.mapOptions.fitMaxZoom, context.map.getZoom()));
            });
            context.map.fitBounds(bounds);
            console.log('Changed map bounds');
        }
    }
};
