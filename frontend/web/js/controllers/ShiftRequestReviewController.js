/**
 * Controller shift request review
 * 
 * @author markov
 */
var ShiftRequestReviewController = {
    
    /**
     * Init
     */
    init: function() {
        $(document).on('submit', '#shift-request-review-form', function() {
            var $form = $(this);
            $.ajax({
                url: $form.attr('action'),
                type: 'post',
                data: $form.serializeArray(),
                success: function(data) {

                    if (data === 'success') {

                        $.colorbox.close();
                        //$.pjax.reload({container: '#shift-form-widget-pjax'});
                        return;

                    } else if ( data.context === 'disputeLog' && data.status === 'success' ) {

                        $.colorbox.close();
                        $('#dispute-log-quantity').html(data.requestReviewCount);
                        $('#last-delivery-count').html(data.deliveryCount);
                        return;
                    }else if (data.context === 'viewHtml' && data.status === 'success' && data.veiwHtml)
                    {
                        $.colorbox.close();
                        $('#shift-request-review').html(data.veiwHtml);

                        return;
                    }


                    var html = $('#shift-request-review-form', $(data)).html();
                    $('#shift-request-review-form').html(html);
                    $(".j_colorbox").colorbox.resize();
                }
            });
            return false;
        });
    }
};


$(document).on('click', '.j_colorbox', function (event) {

    var $that = $(this);
    var colorboxParams = {
        opacity:0.75,
        title:false,
        scrolling:false,
        close:"",
        onComplete: function() {
            var params = {
                changedEl: ".j_select",
                visRows:3,
                scrollArrows:false
            };
            cuSel(params);
            $(".j_colorbox_live").colorbox(colorboxParams);
            $('.j_placeholder').each(function(){
                new Placeholder($(this));
            });
        }
    };

    if ( ! $that.hasClass('cboxElement') ) {

        event.preventDefault();
        $that.colorbox(colorboxParams);
        $that.click();
    }
});