var ShiftViewWidget = {
    
    /**
     * Init
     */
    init: function() {
        $('.js-shift-approve').on('click', function(e) {

            e.preventDefault();
            $.get($(this).attr('href'), function() {
                
            });
            e.stopPropagation();
            return false;
        });

        $('#js-delete-shift').on('click', function(e){
            e.preventDefault();

            if (confirm('Are you sure?')){
                $.post($(this).attr('href'), function(response){
                   $("#roster-sidebar").addClass("without-col-left");
                })
            }
        });
    }
};