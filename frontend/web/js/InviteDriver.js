/**
 * Adding and removing store owner's favourite drivers
 *
 * @type {{options: {inviteButtonSelector: string, removeButtonSelector: string, favouriteStar: string, addUrl: string, removeUrl: string}, init: Function, initEvents: Function}}
 */
var InviteDriver = {

    /**
     * Options
     */
    options: {
        inviteButtonSelector: '.j_invite-driver',
        removeButtonSelector: '.j_disconnect-driver',
        inviteUrl: '/drivers/invite',
        removeUrl: '/drivers/disconnect',
        inviteMessageSelector: '.j_invited_message',
        confirmMessageSelector: '.j_confirm_message'
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
            inviteButton = this.options.inviteButtonSelector,
            removeButton = this.options.removeButtonSelector,
            inviteDiv = this.options.inviteMessageSelector,
            confirmDiv = this.options.confirmMessageSelector,
            star = this.options.favouriteStar;

        $(document).on('click', this.options.inviteButtonSelector, function (e) {
            e.preventDefault();
            driverId = $(this).data('driverid');

            $.ajax({
                type: 'POST',
                url: self.options.inviteUrl,
                data: {
                    driverId: driverId
                },
                success: function (result) {
                    if (result.success) {
                        $(inviteButton).addClass('hidden');
                        //$row.find(removeButton).removeClass('hidden');
                        $(inviteDiv).removeClass('hidden');
                    }
                },
                dataType: 'json'
            });
        });

        $(document).on('click', this.options.removeButtonSelector, function (e) {
            e.preventDefault();
            driverId = $(this).data('driverid');


            $.ajax({
                type: 'POST',
                url: self.options.removeUrl,
                data: {
                    driverId: driverId
                },
                success: function (result) {
                    if (result.success) {
                        $(inviteButton).removeClass('hidden');

                        $(confirmDiv).addClass('hidden');
                        $(inviteDiv).addClass('hidden');
                    }
                },
                dataType: 'json'
            });
        });
    }
};