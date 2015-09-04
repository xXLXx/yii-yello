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
            position: [0, 0],
            accessToken: null
        },
        drivers: [],
        inactiveDriverTimeout: 30000,
        updateDriversInterval: 60000,
        markerAnimation: {
            speed: 50,
            delay: 50,
            enabled: false
        },
        pubnub: {
            publishKey: '',
            subscribeKey: ''
        }
    },

    map: null,

    pubnub: null,

    // drivers that are currently on the map
    mapDrivers: {},

    driverChannelPrefix: 'driver_',

    driverCount: 0,

    mapBoundsChanged: false,

    markerClusterer: null,

    // The interval to auto update map drivers
    updateDriversIntervalInstance: null,

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
            
            context.updateDriversIntervalInstance = setInterval(function () {
                context.updateMapDrivers();
            }, context.data.updateDriversInterval);
            context.updateMapDrivers();

            // Subscribe to PN strore channe;
            context.pubnub.subscribe({
                channel : 'store_' + context.data.store.id,
                message : function (m) {
                    console.log(m);
                    // See if something has changed
                    if (!context.mapDrivers[m.driver_id]) {
                        context.updateMapDrivers();

                        // Delay update map drivers interval to start on next [updateDriversInterval] milliseconds
                        clearInterval(context.updateDriversIntervalInstance);
                        context.updateDriversIntervalInstance = setInterval(function () {
                            context.updateMapDrivers();
                        }, context.data.updateDriversInterval);
                    }
                }
            });

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
                zIndex: -Number.MAX_SAFE_INTEGER,
                optimized: false
            });
        });

        context.pubnub = PUBNUB({
            publish_key   : context.data.pubnub.publishKey,
            subscribe_key : context.data.pubnub.subscribeKey,
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
     * Removes a map driver by driverId
     *
     * @return true when removed, false when not found
     */
    removeMapDriver: function (driverId) {
        if (this.mapDrivers[driverId]) {
            this.pubnub.unsubscribe({
                channel: this.driverChannelPrefix + driverId
            });
            this.mapDrivers[driverId].marker.setMap(null);
            this.updateDriverCount(-1);
            this.markerClusterer.removeMarker(this.mapDrivers[driverId].marker);
            delete this.mapDrivers[driverId];

            return true;
        }

        return false;
    },

    /**
     * Adds a new map driver
     *
     * @param driver object serialized version of common\models\User
     * @return false if unable to add, and true when successful
     */
     addMapDriver: function (driver) {
        var context = this;
        var mapDriversCurrentIdx = driver.id;

        // Do not add when existing
        if (context.mapDrivers[mapDriversCurrentIdx]) {
            return false;
        }
        context.mapDrivers[mapDriversCurrentIdx] = {
            driver: driver,
            pubnubCallback: function (m) {
                if (!m.time || !m.driver_id || !m.lat || !m.lng) {
                    console.log('Error parsing: %O', m);
                    return;
                }

                context.mapDrivers[mapDriversCurrentIdx].state = m;
                context.mapDrivers[mapDriversCurrentIdx].lastUpdate = new Date();
                var position = new google.maps.LatLng(m.lat, m.lng);
                // Check if marker is on shift on current store
                if (Number(m.store_id) == context.data.store.id) {
                    if (context.mapDrivers[mapDriversCurrentIdx].marker) {
                        context.animateMarker(context.mapDrivers[mapDriversCurrentIdx].marker, [[m.lat, m.lng]]);
                    } else {
                        context.mapDrivers[mapDriversCurrentIdx].marker = context.createDriverMarker(position, driver.id);
                    }
                } else {
                    context.removeMapDriver(driver.id);
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
                            context.mapDrivers[mapDriversCurrentIdx].marker = context.createDriverMarker(position, driver.id);
                        }
                    } else {
                        // Place marker on store's location (default) this means channel has no history
                        context.mapDrivers[mapDriversCurrentIdx].marker = context.createDriverMarker(
                            new google.maps.LatLng(context.data.store.position[0], context.data.store.position[1]),
                            driver.id
                        );
                    }
                }
                if (--context.historyCallbacksLoaded <= 0) {
                    context.zoomFitMapMarkers();
                }
            }
        };

        context.pubnub.subscribe({
            channel : context.driverChannelPrefix + driver.id,
            message : context.mapDrivers[mapDriversCurrentIdx].pubnubCallback,
        });
        context.pubnub.history({
            channel: context.driverChannelPrefix + driver.id,
            callback: context.mapDrivers[mapDriversCurrentIdx].historyCallback,
            count: 1,
        });

        return true;
    },

    /**
     * Checks from API all active drivers then validates then with the current map drivers
     */
    updateMapDrivers: function () {
        var context = this;
        $.ajax({
            url: document.location.protocol + '//' + document.location.hostname + '/v1/driver/active',
            data: {
                storeid: context.data.store.id
            },
            headers: {
                'access-token': context.data.store.accessToken
            }
        }).done(function (response) {
            console.log(response);

            // Traverse though map drivers and determine which is currenlty active or not
            $.each(context.mapDrivers, function (mapDriverKey, mapDriver) {
                var found = false;
                $.each(response.items, function (drivereKey, driver) {
                    if (driver.id == mapDriver.driver.id) {
                        found = true;
                        return false;
                    }
                });

                // If map driver is not found from API active drivers, it means map driver is already invalid
                if (!found) {
                    context.removeMapDriver(mapDriverKey);
                }
            });

            // Traverse through the API's list of drivers and see which should be added to map drivers
            context.historyCallbacksLoaded = response.items.length;
            $.each(response.items, function (driverKey, driver) {
                if (!context.mapDrivers[driver.id]) {
                    context.addMapDriver(driver);
                }
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
