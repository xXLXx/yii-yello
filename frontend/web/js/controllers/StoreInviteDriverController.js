/**
 * Controller store invite driver
 * 
 * @author markov
 */
var StoreInviteDriverController = {
    
    /**
     * Init
     */
    init: function() {
        $(document).on('submit', '#store-invite-driver-form', function() {
            var $form = $(this);
            $.ajax({
                url: $form.attr('action'),
                type: 'post',
                data: $form.serializeArray(),
                success: function(data) {
                    if (data == 'success') {
                        $.colorbox.close();
                        return; 
                    } 
                    var html = $('#store-invite-driver-form', $(data)).html();
                    $('#store-invite-driver-form').html(html);
                    $(".j_colorbox").colorbox.resize();
                }
            });
            return false;
        });
    }
};