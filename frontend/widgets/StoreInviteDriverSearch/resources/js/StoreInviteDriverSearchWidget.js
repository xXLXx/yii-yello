var StoreInviteDriverSearchWidget = {
    
    data: {},
    
    getContainerName: function() {
        return '.js-driver-search-widget-results';
    },
    
    /**
     * Init
     */
    init: function(data) {
        var self = this;
        this.data = data;
        var waitHelper = new WaitHelper();
        $(document).on('keyup', '.js-driver-search-widget-search', function() {
            var searchText = $(this).val();
            waitHelper.wait(500, function() {
                self.loadDrivers(searchText, function(result) {
                    var $searchSelect = $(
                        self.getContainerName() + ' .j_search_select'
                    );
                    $searchSelect.html(result);
                    $('.popup.store-invite').addClass('height-active');
                    $searchSelect.show();
                    $(self.getContainerName() + ' .j_scrollpane').jScrollPane();
                    $(".j_colorbox").colorbox.resize();
                });
            });
        });
        
        $(document).on(
            'click', this.getContainerName() + ' .js-search-select-item', 
            function() {
                $(self.getContainerName() + ' .j_search_select').hide();
                $('.popup.store-invite').removeClass('height-active');
                var driverId = $(this).data('driver-id');
                $(self.getContainerName() + ' .js-driver-input').val(driverId);
                self.loadDriverSelected(driverId, function(result) {
                    if (!result || !result.length) {
                        return false;
                    }
                    var $searchSelectDrivers = $(
                        self.getContainerName() + ' .j_search_select_drivers'
                    );
                    $searchSelectDrivers.html(result);
                    $searchSelectDrivers.show();
                    $(".j_colorbox").colorbox.resize();
                });
            }
        );
    },
    
    loadDrivers: function(searchText, callback) {
        $.ajax({
            type: "POST",
            url: this.data.sourceAutocompleteUrl,
            data: {
                searchText: searchText
            },
            success: function(result) {
                callback(result);
            }
        });
    },
    loadDriverSelected: function(driverId, callback) {
        $.ajax({
            type: "POST",
            url: this.data.sourceSelectedUrl,
            data: {
                driverId: driverId
            },
            success: function(result) {
                callback(result);
            }
        });
    }
};