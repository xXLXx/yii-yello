var DriverSearchWidget = {
    
    data: {},
    
    getContainer: function() {
        return $('.js-driver-search-widget-results');
    },
    
    /**
     * Init
     */
    init: function(data) {
        var self = this;
        this.data = data;
        var waitHelper = new WaitHelper();
        $('.js-driver-search-widget-search').on('keyup', function() {
                $('.js-driver-visible-group-container input[type=checkbox]').each(function(){
                        $("label[for='" + this.id + "']").removeClass('active').addClass('disabled');
                        $(this).prop("checked",true);
                });            
            var searchText = $(this).val();
            waitHelper.wait(500, function() {
                self.loadDrivers(searchText, function(result) {
                    var $searchSelect = $(
                        '.j_search_select', self.getContainer()
                    );
                    $searchSelect.html(result);
                    $searchSelect.show();
                    $('.j_scrollpane', self.getContainer()).jScrollPane();
                });
            });
        });
        
        this.getContainer().on('click', '.js-search-select-item', function() {
            $('.j_search_select', self.getContainer()).hide();
                $('.js-driver-visible-group-container input[type=checkbox]').each(function(){
                        $("label[for='" + this.id + "']").removeClass('active').addClass('disabled');
                });
            var driverId = $(this).data('driver-id');
            $('.js-driver-input', self.getContainer()).val(driverId);
            self.loadDriverSelected(driverId, function(result) {
                if (!result || !result.length) {
                    $('.assigned-shifts-filter').removeClass('allocate');
                    return false;
                }
                var $searchSelectDrivers = $(
                    '.j_search_select_drivers', self.getContainer()
                );
                $searchSelectDrivers.html(result);
                $searchSelectDrivers.show();
                $('.assigned-shifts-filter').addClass('allocate');
            });
//            $('.j_post_btn').hide();
//            $('.j_allocate_btn').show();
        });
    },
    
    loadDrivers: function(searchText, callback) {
        var driverGroup = $('.js-driver-group-radio:checked').val();
        $.ajax({
            type: "POST",
            url: this.data.sourceAutocompleteUrl,
            data: {
                searchText: searchText,
                driverGroup: driverGroup
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