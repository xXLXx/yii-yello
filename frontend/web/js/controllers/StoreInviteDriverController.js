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

                    if (data.search('success') != -1) {
                        var html = $('.success_message', data).html();
                        $('#store-invite-driver-form .popup-body-inner').html(html);
                        $('.popup.store-invite').removeClass('with-error').removeClass('height-active');
                        $(".j_colorbox").colorbox.resize();
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