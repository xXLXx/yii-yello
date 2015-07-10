var ShiftViewWidget = {
    
    /**
     * Init
     */
    init: function() {
        $('.js-shift-approve').on('click', function(e) {
            $.get($(this).attr('href'), function() {
                $.pjax.reload({container: '#shift-form-widget-pjax'});
            });
            e.stopPropagation();
            return false;
        });
    }
};