var ShiftViewDriverAcceptedWidget = {
    
    /**
     * Init
     */
    init: function() {
        $('.js-driver-unassign').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: $(this).attr('href'),
                success: function(result) {
                    if (result && result.redirectUrl) {
                        $.pjax({ 
                            url: result.redirectUrl, 
                            container: '#shift-form-widget-pjax' 
                        });
                        return;
                    }
                    $.pjax.reload({container: '#shift-form-widget-pjax'});
                },
                dataType: 'json'
            });
            e.stopPropagation();
            return false;
        });
    }
};