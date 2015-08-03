/**
 * Drivers page search filter controller
 */
var DriversFilter = {

    /**
     * Initialization
     */
    init: function () {
        this.initEvents();
    },

    /**
     * Events initialization
     */
    initEvents: function () {
        /*$('.j_driver-filter-form input').on('change', function () {
            $('.j_driver-filter-form').submit();
        });*/
        $('.j_driver-filter-item-remove').on('click', function (e) {
            e.preventDefault();
            var value = $(this).data('val');
            $('.j_driver-filter-form input[value="' + value + '"]')
                .removeAttr('checked').val(0);
            $('.j_driver-filter-form').submit();
        });
        $('.j_driver-filter-clear').on('click', function (e) {
            e.preventDefault();
            var $form = $('.j_driver-filter-form');
            $form.find('input[type="checkbox"]:not(.j_no-reset),'
                + ' input[type="radio"]:not(.j_no-reset)')
                    .removeAttr('checked');
            $form.submit();
        });
        //Checkbox
        $(document).on("click", ".j_filter-checkbox", function() {
            if($(this).hasClass("active")) {
                $(this).removeClass("active");
            } else {
                $(this).addClass("active");
            }
        });
    }
};