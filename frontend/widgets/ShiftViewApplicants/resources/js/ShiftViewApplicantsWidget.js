var ShiftViewApplicantsWidget = {

    /**
     * Init
     */
    init: function() {
        $('.js-applicant-control').on('click', function(e) {
            $.get($(this).attr('href'), function() {
                $.pjax.reload({container: '#shift-form-widget-pjax'});
            });
            e.stopPropagation();
            return false;
        });
    }
};