/**
 * Adding and removing store owner's favourite drivers
 *
 * @type {{options: {addButtonSelector: string, removeButtonSelector: string, favouriteStar: string, addUrl: string, removeUrl: string}, init: Function, initEvents: Function}}
 */
var AddFavouriteDriver = {

    /**
     * Options
     */
    options: {
        addButtonSelector: '.j_add-favourite-driver',
        removeButtonSelector: '.j_remove-favourite-driver',
        favouriteStar: '.j_favourite-star',
        addUrl: '/drivers/add-favourite',
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

        $(document).on('click', this.options.addButtonSelector, function (e) {
            e.preventDefault();
            var $row = $(this).closest('tr'),
                driverId = $row.data('key');
            $.ajax({
                type: 'POST',
                url: self.options.addUrl,
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
            var $row = $(this).closest('tr'),
                driverId = $row.data('key');
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