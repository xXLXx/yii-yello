var ShiftFormWidget = {
    
    /**
     * Init
     */
    init: function() {
        var self = this;
        this.driverSearchShow($('.js-driver-group-radio:checked'));
        $('.js-driver-visible-group-container input[type=radio]').on('change',  
            function() {
                self.driverSearchShow($('.js-driver-group-radio:checked'));
            }
        );
    },
    
    driverSearchShow: function($container)
    {
        var value = $container.val();
        var $driverSearchContainer = $('.js-driver-search-container');
        if (value == 'isMyDrivers') {
            $driverSearchContainer.removeClass('hide');
        } else {
            $driverSearchContainer.addClass('hide');
        }
    }
};