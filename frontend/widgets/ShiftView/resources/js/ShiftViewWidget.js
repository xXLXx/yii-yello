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

        $('#js-delete-shift').on('click', function(e){
            e.preventDefault();

            if (confirm('Are you sure?')){
                $.post($(this).attr('href'), function(response){
                    window.location.href = '/shifts-calendar';
                })
            }
        });
    }
};