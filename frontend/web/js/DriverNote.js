/**
 * Adding and removing store owner's favourite drivers
 *
 * @type {{options: {inviteButtonSelector: string, removeButtonSelector: string, favouriteStar: string, addUrl: string, removeUrl: string}, init: Function, initEvents: Function}}
 */
var DriverNote = {

    /**
     * Options
     */
    options: {
        inviteButtonSelector: '.j_invite-driver',
        removeButtonSelector: '.j_remove-favourite-driver',
        favouriteStar: '.j_favourite-star',
        inviteUrl: '/drivers/invite',
        removeUrl: '/drivers/remove-favourite'
    },

    /**
     * Initialization
     *
     * @param options
     */
    init: function (options) {
        $.extend(this.options, options);
        this.initEvents();
    },

    /**
     * Events initialization
     */
    initEvents: function () {
        var self = this,
            addButton = this.options.addButtonSelector,
            removeButton = this.options.removeButtonSelector,
            star = this.options.favouriteStar;

        $(document).on('click', this.options.inviteButtonSelector, function (e) {
            e.preventDefault();
            driverId = $(this).data('driverid');
            $row = $('.info-popup');
            $.ajax({
                type: 'POST',
                url: self.options.inviteUrl,
                data: {
                    driverId: driverId
                },
                success: function (result) {
                    if (result.success) {
                        $row.find(star).removeClass('hidden');
                        $row.find(addButton).addClass('hidden');
                        $row.find(removeButton).removeClass('hidden');
                    }
                },
                dataType: 'json'
            });
        });

        $(document).on('click', this.options.removeButtonSelector, function (e) {
            e.preventDefault();
            driverId = $(this).data('driverid');
            if(!driverId) {
                var $row = $(this).closest('tr'),
                    driverId = $row.data('key');
            } else {
                $row = $('.info-popup');
            }
            $.ajax({
                type: 'POST',
                url: self.options.removeUrl,
                data: {
                    driverId: driverId
                },
                success: function (result) {
                    if (result.success) {
                        $row.find(star).addClass('hidden');
                        $row.find(addButton).removeClass('hidden');
                        $row.find(removeButton).addClass('hidden');
                    }
                },
                dataType: 'json'
            });
        });
    }
};