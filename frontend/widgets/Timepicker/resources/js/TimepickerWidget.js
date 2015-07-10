/**
 * @author markov
 */
var TimepickerWidget = {
    
    /**
     * Init
     */
    init: function(id) {
        $(function() {
            var $container = $('#' + id);
            $container.clockpicker({
                donetext: 'done',
                autoclose: true
            });
        });
    }
    
};